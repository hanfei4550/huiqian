<?php
/**
 * 会签服务入口类,主要用户接收微信端发送到会签的请求
 * User: coffeecat
 * Date: 2015-10-31
 * Time: 23:16
 */
//define('APP_ID', 'wxec230c866b34a22b');
//define('APP_SECRET', 'd40a6ee899991f07763f9a44af53b584');
include('log4php/Logger.php');
Logger::configure('log4php-config.xml');
$log = Logger::getLogger('myLogger');
$config = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . "config.php");
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $code = "";
    $state = "";
    $type = "";
    $activity_no = "";
    if (isset($_GET["code"]))//微信网页授权之后传递的code
    {
        $code = $_GET['code'];//存在
    }
    if (isset($_GET["state"]))//微信网页授权传递的state
    {
        $state = $_GET['state'];//存在
    }
    if (isset($_GET["activityno"]))//获取活动号
    {
        $activity_no = $_GET['activityno'];//存在
    }
    if ($code != "" && $state != "") {

        require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "WXUtils.php");

        $wxUtils = new WXUtils();

        $token_json = $wxUtils->getToken($code);

        $openid = $token_json['openid'];

        $userinfo_json = $wxUtils->getUserInfo($token_json);

        $env = $config['env'];

        if (!isset($userinfo_json['nickname'])) {
            header($config[$env . '.' . 'userinfo_get_error_url']);
            exit;
        }
        $nickname = $userinfo_json['nickname'];
        $nickname = translate_nick($nickname);
        $log->warn("用户昵称:" . $nickname);
        $headimgurl = $userinfo_json['headimgurl'];
        $headimgurl = $wxUtils->resizeHeadImage($headimgurl);

        require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "ActivityService.php");
        $activityService = new ActivityService();
        if ($activity_no != "") {
            $activityInfo = $activityService->getActivityByActivityNo($activity_no);
        } else {
            $activityInfo = $activityService->getCurrentActivity();
        }
        if (count($activityInfo) == 0) {
            header($config[$env . '.' . 'no_activity_url']);
            exit;
        }
        $userId = $activityInfo['user_id'];
        $activityId = $activityInfo['activity_id'];
        $banner = $activityInfo['banner'];
        $isValidateUser = $activityInfo['is_validate_user'];
        $is_danmu = $activityInfo['is_danmu'];
        $userinfo_url = $activityInfo['userinfo_url'];
        $signsuccess_url = $activityInfo['signsuccess_url'];
        require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "FansService.php");
        $fansService = new FansService();
        $fansInfo = $fansService->getFansHeadPortraintByNick($nickname, $userId, $activityId);
        $headImage = $fansInfo['headImage'];
        $fansId = $fansInfo['fansId'];
        $log->warn("用户头像:" . $headImage . ";用户ID:" . $fansId);
        $currentDate = date("Ymd");
        $log->warn("用户的openId:" . $openid);
        if (empty($headImage)) {
            if ($isValidateUser == $config['no_validate_user_flag']) {
                //保存用户信息到用户表中
                $fansId = $fansService->insertFans($nickname, $headimgurl, $openid);

                //获取用户的签到序号
                $orderNum = $fansService->getUserCountByActivity($userId, $activityId);


                //插入用户活动粉丝表
                $fansService->insertUserActivityFans($userId, $activityId, $fansId, $orderNum);

                if ($activityId == 33) {
                    $fansService->insertUserActivityFans($userId, 34, $fansId, $orderNum);
                }
            }
            $log->warn("是否弹幕活动:" . $is_danmu);
            if ($is_danmu == "1") {
                $signResult = build_userinfo($userId, $activityId, $orderNum, $nickname, $headimgurl, $openid, $fansId);
                if (empty($signsuccess_url)) {
                    $signsuccess_url = $config[$env . '.' . 'sign_success_url'];
                }
                $log->warn("跳转的url地址:" . $signsuccess_url);
                header("Location:" . $signsuccess_url . "?userInfo=" . json_encode($signResult));
                exit;
            } else {
                if (empty($userinfo_url)) {
                    $userinfo_url = $config[$env . '.' . 'userinfo_collect_url'];
                }
                header("Location:" . $userinfo_url . "?userId=$userId&activityId=$activityId&nick=" . urlencode($nickname) . "&headImage=" . $headimgurl . "&banner=" . $banner . "&isValidateUser=" . $isValidateUser . "&openId=" . $openid);
                exit;
            }
        } else {
            //如果用户信息存在则更新用户的openid信息
            $log->warn("用户的openId:" . $openid . ";用户昵称:" . $nickname . ";头像:" . $headImage);
            $fansService->insertFans($nickname, $headImage, $openid);
            $orderNum = $fansService->getOrderNumByUser($userId, $activityId, $fansId);
            $signResult = build_userinfo($userId, $activityId, $orderNum, $nickname, $headImage, $openid, $fansId);
            if (empty($signsuccess_url)) {
                $signsuccess_url = $config[$env . '.' . 'sign_success_url'];
            }
            $log->warn("跳转的url地址:" . $signsuccess_url);
            header("Location:" . $signsuccess_url . "?userInfo=" . json_encode($signResult));
            exit;
        }
    }
}


function build_userinfo($userId, $activityId, $orderNum, $nickname, $headImage, $openid, $fansId)
{
    $signResult = array();
    $signResult['userId'] = $userId;
    $signResult['activityId'] = $activityId;
    $signResult['fansCount'] = $orderNum;
    $signResult['nick'] = urlencode($nickname);
    $signResult['headImage'] = $headImage;
    $signResult['openid'] = $openid;
    $signResult['fansId'] = $fansId;
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
    if (curl_errno($ch)) {
        sleep(3);
        http_get_data($url);
    }
    $return_content = ob_get_contents();
    ob_end_clean();
    curl_close($ch);
    return $return_content;
}

function download_file_by_curl($file_url, $save_to)
{
    $return_content = http_get_data($file_url);
    if ($return_content === "") {
        return "";
    }
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
    return trim($resultNick, " ");
}