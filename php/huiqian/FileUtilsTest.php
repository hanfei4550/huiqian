<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-10-31
 * Time: 23:09
 */
require_once(dirname(__FILE__) . "/" . "FileUtils.php");
require_once(dirname(__FILE__) . "/" . "RandomUtils.php");
require_once(dirname(__FILE__) . "/" . "FansService.php");

$fileUtils = new FileUtils();
$fileUtils->resizeHeadImageSize("http://wx.qlogo.cn/mmopen/nibxxlib1VaPeAZCeY4P1R6c0RXhTUcejDhTooA1ianTABH48ia9dfAJFFJu7kicuNCBfGwVruUBN5Vewga8Kfzz7fId4w8SHf3Sb/0", 132);


//$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxec230c866b34a22b&secret=d40a6ee899991f07763f9a44af53b584&code=0210e549cf2c10bda40a813f02f883fb&grant_type=authorization_code";

//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//$result = curl_exec($ch);
//curl_close($ch);

//$token_result = '{"access_token":"OezXcEiiBSKSxW0eoylIeDwHUOI1Hi8AbvaZb6k2FLQ21nnO4HneZSOJc71dnr8tMPXjjtpHAFYodMju-hVK_4FC44rFDf7GXJ6kbFh595izZOrD5SldDBzIOj_Y7lT3HAKVSolY4vAP_f-NKMjxRQ","expires_in":7200,"refresh_token":"OezXcEiiBSKSxW0eoylIeDwHUOI1Hi8AbvaZb6k2FLQ21nnO4HneZSOJc71dnr8tRMogGRThKIHXtyp1TLXvt0R28pyIbkNlObNICYV0SCejG6xvf0oiHgHpf_C52eir50TXaJy0m568tWIM7s_qpw","openid":"oE3LPs3bF4hHGsPo7wEsOk3hBu_Q","scope":"snsapi_userinfo"}';
//$token_json = json_decode($token_result, true);
//$access_token = $token_json['access_token'];
//$openid = $token_json['openid'];
//$refresh_token = $token_json['refresh_token'];

//
//$url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//$result = curl_exec($ch);
//curl_close($ch);
//
//$userinfo_json = json_decode($result, true);
//$nickname = $userinfo_json['nickname'];
//$headimgurl = $userinfo_json['headimgurl'];
//
//
//$randomUtils = new RandomUtils();
//$fileName = $randomUtils->generate_random() . '.jpg';
//$fileUtils->download_remote_file($headimgurl, "C:/Users/Administrator/PhpstormProjects/huiqian/download/" . $fileName);
//
//$fansService = new FansService();
//$fansId = $fansService->insertFans($nickname, $fileName);
//
//$userId = 1;
//$activityId = 1;
//
//$fansService->insertUserActivityFans($userId, $activityId, $fansId);



