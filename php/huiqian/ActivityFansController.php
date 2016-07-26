<?php
/**
 * 获取用户的评论信息
 * User: coffeecat
 * Date: 2015-11-22
 * Time: 16:32
 */
include('log4php/Logger.php');
Logger::configure('log4php-config.xml');
$log = Logger::getLogger('myLogger');
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $activityId = "";
    $name = "";
    $phone = "";
    if (isset($_GET["activityId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $activityId = $_GET['activityId'];//存在
    }
    if (isset($_GET["name"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $name = $_GET['name'];//存在
    }
    if (isset($_GET["phone"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $phone = $_GET['phone'];//存在
    }
    $log->warn("活动id:" . $activityId);
    $log->warn("用户名称:" . $name);
    $log->warn("手机号:" . $phone);
    if ($activityId != "" && $name != "" && $phone != "") {
        require_once(dirname(__FILE__) . "/" . "FansService.php");
        $fansService = new FansService();
        $activityFansArr = $fansService->getRegisterUserByParams($activityId, $name, $phone);
        $resultMessage = array();
        $log->warn("用户数量:" . count($activityFansArr));
        if (count($activityFansArr) > 0) {
            $resultMessage['isValid'] = true;
        } else {
            $resultMessage['isValid'] = false;
        }
        echo json_encode($resultMessage);
    }

}
