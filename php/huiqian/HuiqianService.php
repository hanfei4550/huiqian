<?php
/**
 * 会签服务入口类,主要用户接收微信端发送到会签的请求
 * User: coffeecat
 * Date: 2015-10-31
 * Time: 23:16
 */
//define('APP_ID', 'wxec230c866b34a22b');
//define('APP_SECRET', 'd40a6ee899991f07763f9a44af53b584');
define('CURREN_DIRECTORY_SEPATRATOR', '/');
include('log4php/Logger.php');
Logger::configure('log4php-config.xml');
$log = Logger::getLogger('myLogger');
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $code = "";
    $state = "";
    $type = "";
    $is_danmu = "";
    if (isset($_GET["code"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $code = $_GET['code'];//存在
    }
    if (isset($_GET["state"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $state = $_GET['state'];//存在
    }
    if (isset($_GET["isdanmu"]))//判断是否是弹幕互动产品
    {
        $is_danmu = $_GET['isdanmu'];//存在
    }
    if ($code != "" && $state != "") {
        require_once(dirname(__FILE__) . CURREN_DIRECTORY_SEPATRATOR . "WXUtils.php");

        $wxUtils = new WXUtils();

        $token_json = $wxUtils->getToken($code);

        $userinfo_json = $wxUtils->getUserInfo($token_json);

        if (!isset($userinfo_json['nickname'])) {
            header($config['userinfo_get_error_url']);
            exit;
        }
        $nickname = $userinfo_json['nickname'];
        $nickname = translate_nick($nickname);
        $log->warn("用户昵称:" . $nickname);
        $headimgurl = $userinfo_json['headimgurl'];
        $headimgurl = $wxUtils->resizeHeadImage($headimgurl);

        require_once(dirname(__FILE__) . CURREN_DIRECTORY_SEPATRATOR . "ActivityService.php");
        $activityService = new ActivityService();
        $activityInfo = $activityService->getCurrentActivity();
        $config = include(dirname(__FILE__) . CURREN_DIRECTORY_SEPATRATOR . "config.php");

        if (count($activityInfo) == 0) {
            header($config['no_activity_url']);
            exit;
        }

        $userId = $activityInfo['user_id'];
        $activityId = $activityInfo['activity_id'];
        $banner = $activityInfo['banner'];
        $isValidateUser = $activityInfo['is_validate_user'];
        require_once(dirname(__FILE__) . CURREN_DIRECTORY_SEPATRATOR . "FansService.php");
        $fansService = new FansService();
        $log->warn('比较结果:' . strcmp($nickname, 'AbcD '));
        $fansInfo = $fansService->getFansHeadPortraintByNick($nickname, $userId, $activityId);
        $headImage = $fansInfo['headImage'];
        $fansId = $fansInfo['fansId'];
        $log->warn("用户头像:" . $headImage . ";用户ID:" . $fansId);
        $currentDate = date("Ymd");
        if (empty($headImage)) {
            //生成下载的文件名,并且将头像文件下载到本地
            require_once(dirname(__FILE__) . CURREN_DIRECTORY_SEPATRATOR . "RandomUtils.php");
            $randomUtils = new RandomUtils();
            $headImage = $randomUtils->generate_random() . '.jpg';

            $downloadDir = $config['image_download_dir_prefix'] . $currentDate;
            if (!is_dir($downloadDir)) {
                mkdir($downloadDir);
                chmod($downloadDir, 0777);
            }

            download_file_by_curl($headimgurl, $downloadDir . CURREN_DIRECTORY_SEPATRATOR . $headImage);

            if ($isValidateUser == $config['no_validate_user_flag']) {
                //保存用户信息到用户表中
                $fansId = $fansService->insertFans($nickname, $headImage);

                //获取用户的签到序号
                $orderNum = $fansService->getUserCountByActivity($userId, $activityId);

                //插入用户活动粉丝表
                $fansService->insertUserActivityFans($userId, $activityId, $fansId, $orderNum);
            }

            if ($is_danmu == "true") {
                $signResult = build_userinfo($userId, $activityId, $orderNum, $nickname, $headImage, $config, $currentDate);
                header($config['sign_success_url'] . "?userInfo=" . json_encode($signResult));
                exit;
            } else {
                header($config['userinfo_collect_url'] . "?userId=$userId&activityId=$activityId&nick=" . urlencode($nickname) . "&headImage=" . $headImage . "&banner=" . $banner . "&isValidateUser=" . $isValidateUser);
                exit;
            }
        } else {
            $orderNum = $fansService->getOrderNumByUser($userId, $activityId, $fansId);
            $signResult = build_userinfo($userId, $activityId, $orderNum, $nickname, $headImage, $config, $currentDate);
            header($config['sign_success_url'] . "?userInfo=" . json_encode($signResult));
            exit;
        }
    }
}


function build_userinfo($userId, $activityId, $orderNum, $nickname, $headImage, $config, $currentDate)
{
    $signResult = array();
    $signResult['userId'] = $userId;
    $signResult['activityId'] = $activityId;
    $signResult['fansCount'] = $orderNum;
    $signResult['nick'] = urlencode($nickname);
    $signResult['headImage'] = $config['image_get_url_prefix'] . $currentDate . CURREN_DIRECTORY_SEPATRATOR . $headImage;
    return $signResult;
}

function http_get_data($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    ob_start();
    curl_exec($ch);
    $return_content = ob_get_contents();
    ob_end_clean();
    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return $return_content;
}

function download_file_by_curl($file_url, $save_to)
{
    $return_content = http_get_data($file_url);
    $fp = @fopen($save_to, "a"); //将文件绑定到流
    fwrite($fp, $return_content); //写入文件
    fclose($fp);
}

function str_split_unicode($str, $l = 0)
{
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function translate_nick($nickname)
{
    $resultNick = "";
    $results = str_split_unicode($nickname);
    $reg = '/[a-zA-Z0-9\[\]\x{4e00}-\x{9fa5}\s]+/u';
    foreach ($results as $result) {
        if (preg_match($reg, $result)) {
            $resultNick = $resultNick . $result;
        }
    }
    return $resultNick;
}