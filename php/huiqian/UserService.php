<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-1
 * Time: 18:07
 */
//为了解决方法调用传递中文参数乱码的问题
header("Content-Type: text/html; charset=utf-8");

if (is_array($_POST) && count($_POST) > 0)//判断是否有POST参数
{
    $name = "";
    $phone = "";
    $nick = "";
    $userId = "";
    $activityId = "";
    $headImage = "";
    if (isset($_POST["name"])) {
        $name = $_POST['name'];
    }
    if (isset($_POST["phone"])) {
        $phone = $_POST['phone'];
    }
    if (isset($_POST["nick"])) {
        $nick = $_POST['nick'];
    }
    if (isset($_POST["userId"])) {
        $userId = $_POST['userId'];
    }
    if (isset($_POST["activityId"])) {
        $activityId = $_POST['activityId'];
    }
    if (isset($_POST["headImage"])) {
        $headImage = $_POST['headImage'];
    }

    if ($name != "" && $phone != "" && $nick != "") {
        require_once(dirname(__FILE__) . "/" . "FansService.php");
        $fansService = new FansService();
        $fansService->updateFans($name, $phone, $nick);
        $fansId = $fansService->getFansIdByNick($nick);
        $fansCount = $fansService->getOrderNumByUser($userId, $activityId,$fansId);

        $signResult = array();
        $signResult['userId'] = $userId;
        $signResult['activityId'] = $activityId;
        $signResult['fansCount'] = $fansCount;
        $signResult['nick'] = urlencode($nick);
        $signResult['headImage'] = "http://www.hn-coffeecat.cn/cmstest/images/huiqian/" . $headImage;

        header("Location: http://www.hn-coffeecat.cn/huiqian/sign-success.php?userInfo=" . json_encode($signResult));
        exit;
    }
}