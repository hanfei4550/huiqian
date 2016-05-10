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
    $isValidateUser = "";
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
    if (isset($_POST["isValidateUser"])) {
        $isValidateUser = $_POST['isValidateUser'];
    }

    if ($name != "" && $phone != "" && $nick != "") {
        require_once(dirname(__FILE__) . "/" . "FansService.php");
        $config = include(dirname(__FILE__) . "/" . "config.php");
        $fansService = new FansService();
        if ($isValidateUser == $config['not_validate_user_flag']) {
            $fansService->updateFans($name, $phone, $nick);
        } else {
            $fansArr = $fansService->getAllRegisterUserByActivity($activityId);
            if (in_array($name . ":" . $phone, $fansArr)) {
                //保存用户信息到用户表中
                $fansId = $fansService->insertFansWithNameAndPhone($nickname, $headImage, $name, $phone);
                //获取用户的签到序号
                $orderNum = $fansService->getUserCountByActivity($userId, $activityId);
                //插入用户活动粉丝表
                $fansService->insertUserActivityFans($userId, $activityId, $fansId, $orderNum);
            } else {
                header($config['userinfo_get_error_url']);
                exit;
            }
        }
        $fansId = $fansService->getFansIdByNick($nick);
        if (empty($fansId)) {
            header($config['userinfo_get_error_url']);
            exit;
        }
        $fansCount = $fansService->getOrderNumByUser($userId, $activityId, $fansId);
        $signResult = array();
        $signResult['userId'] = $userId;
        $signResult['activityId'] = $activityId;
        $signResult['fansCount'] = $fansCount;
        $signResult['nick'] = urlencode($nick);
        $currentDate = date(Ymd);
        $signResult['headImage'] = HEAD_IMAGE_DIR . $currentDate . '/' . $headImage;
        header($config['sign_success_url'] . "?userInfo=" . json_encode($signResult));
        exit;
    }
}