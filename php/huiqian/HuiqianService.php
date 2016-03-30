<?php
/**
 * 会签服务入口类,主要用户接收微信端发送到会签的请求
 * User: coffeecat
 * Date: 2015-10-31
 * Time: 23:16
 */
$appId = "wxec230c866b34a22b";
$appSecret = "d40a6ee899991f07763f9a44af53b584";

if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $code = "";
    $state = "";
    if (isset($_GET["code"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $code = $_GET['code'];//存在
    }

    if (isset($_GET["state"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $state = $_GET['state'];//存在
    }
//    echo $code . '<br/>';
//    echo $state . '<br/>';
    if ($code != "" && $state != "") {
        require_once(dirname(__FILE__) . "/" . "FileUtils.php");
        $fileUtils = new FileUtils();
        //调用微信公众号获取token的接口，以便能够通过token获取到用户的基本信息
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appId . '&secret=' . $appSecret . '&code=' . $code . '&grant_type=authorization_code';
        $tokenResult = $fileUtils->get_content($url);
//        echo $tokenResult;
        //解析token获取到access_token，openid和refresh_token
//        $tokenResult = '{"access_token":"OezXcEiiBSKSxW0eoylIeDwHUOI1Hi8AbvaZb6k2FLQ21nnO4HneZSOJc71dnr8tb1GcIcrB6FtLzPXWEPtOvUIjW2x5GXrhJCwxU_JkAoX786p8xnvD74l9dEqWn8fL3YeVQWbyjEBVRh0IOjOdjQ","expires_in":7200,"refresh_token":"OezXcEiiBSKSxW0eoylIeDwHUOI1Hi8AbvaZb6k2FLQ21nnO4HneZSOJc71dnr8tRz5DOp6TNTWKVPBD_EPElI_n5k7ACBKY_i5Bjn-CYPAhC0nq2_45vX61EjZ0I6qr81GiuhzVBadpWUt9HDl7uA","openid":"oE3LPs3bF4hHGsPo7wEsOk3hBu_Q","scope":"snsapi_userinfo"}';
        $token_json = json_decode($tokenResult, true);
        $access_token = $token_json['access_token'];
        $openid = $token_json['openid'];
        $refresh_token = $token_json['refresh_token'];

        //调用微信公众号获取用户信息接口获取昵称和头像
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $userInfoResult = $fileUtils->get_content($url);
//        echo $userInfoResult . '<br/>';

//        $userInfoResult = '{"openid":"oE3LPs3bF4hHGsPo7wEsOk3hBu_Q","nickname":"coffeecat","sex":1,"language":"zh_CN","city":"长沙","province":"湖南","country":"中国","headimgurl":"http:\/\/wx.qlogo.cn\/mmopen\/nibxxlib1VaPeAZCeY4P1R6c0RXhTUcejDhTooA1ianTABH48ia9dfAJFFJu7kicuNCBfGwVruUBN5Vewga8Kfzz7fId4w8SHf3Sb\/0","privilege":[]}';
        $userinfo_json = json_decode($userInfoResult, true);
        $nickname = $userinfo_json['nickname'];
        $headimgurl = $userinfo_json['headimgurl'];
        $headimgurl = $fileUtils->resizeHeadImageSize($headimgurl, 132);

        require_once(dirname(__FILE__) . "/" . "ActivityService.php");
        $activityService = new ActivityService();
        $startTime = time();
        $activityInfo = $activityService->getCurrentActivity();

        if (count($activityInfo) == 0) {
            header("Location: http://www.hn-coffeecat.cn/huiqian/no-activity.html");
            exit;
        }

//        $firstCost = microtime() - $startTime;
//        echo "getCurrentActivity 耗费时间:".$firstCost;

        $userId = $activityInfo['user_id'];
        $activityId = $activityInfo['activity_id'];
        $banner = $activityInfo['banner'];

        require_once(dirname(__FILE__) . "/" . "FansService.php");
        $fansService = new FansService();
        $fansInfo = $fansService->getFansHeadPortraintByNick($nickname);

        $headImage = $fansInfo['headImage'];
        $fansId = $fansInfo['fansId'];

//        $secondCost = time() - $startTime;
//        echo "getFansHeadPortraintByNick 耗费时间:".$secondCost;

        if (empty($headImage)) {
            //生成下载的文件名,并且将头像文件下载到本地
            require_once(dirname(__FILE__) . "/" . "RandomUtils.php");
            $randomUtils = new RandomUtils();
            $headImage = $randomUtils->generate_random() . '.jpg';
            download_file_by_curl($headimgurl, "/var/www/html/cmstest/images/huiqian/" . $headImage);
//            $fileUtils->download_remote_file($headimgurl, "/var/www/html/cmstest/images/huiqian/" . $headImage);
//        $fileUtils->download_remote_file($headimgurl, "C:/Users/Administrator/PhpstormProjects/huiqian/download" . $fileName);
//            $thirdCost = time() - $startTime;
//            echo "download_remote_file 耗费时间:".$thirdCost;

            //保存用户信息到用户表中
            $fansId = $fansService->insertFans($nickname, $headImage);

//            $fourthCost = microtime() - $startTime;
//            echo "insertFans 耗费时间:".$fourthCost;
            //获取用户的签到序号
            $orderNum = $fansService->getUserCountByActivity($userId, $activityId);

//            $fiveCost = microtime() - $startTime;
//            echo "getUserCountByActivity 耗费时间:".$fiveCost;

            //插入用户活动粉丝表
            $fansService->insertUserActivityFans($userId, $activityId, $fansId, $orderNum);

//            $sixCost = microtime() - $startTime;
//            echo "insertUserActivityFans 耗费时间:".$sixCost;
            header("Location: http://www.hn-coffeecat.cn/huiqian/user-info-collection.php?userId=$userId&activityId=$activityId&nick=" . urlencode($nickname) . "&headImage=" . $headImage . "&banner=" . $banner);
            exit;
        } else {
            $orderNum = $fansService->getOrderNumByUser($userId, $activityId,$fansId);
            $signResult = array();
            $signResult['userId'] = $userId;
            $signResult['activityId'] = $activityId;
            $signResult['fansCount'] = $orderNum;
            $signResult['nick'] = urlencode($nickname);
            $signResult['headImage'] = "http://www.hn-coffeecat.cn/cmstest/images/huiqian/" . $headImage;
            header("Location: http://www.hn-coffeecat.cn/huiqian/sign-success.php?userInfo=" . json_encode($signResult));
            exit;
        }

    }
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