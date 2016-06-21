<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-22
 * Time: 16:32
 */
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $id = "";
    $type = "";
    $flag = "";
    $activityNo = "";
    if (isset($_GET["id"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $id = $_GET['id'];//存在
    }
    if (isset($_GET["type"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $type = $_GET['type'];//存在
    }
    if (isset($_GET["flag"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $flag = $_GET['flag'];//存在
    }
    if (isset($_GET["activityno"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $activityNo = $_GET['activityno'];//存在
    }
    require_once(dirname(__FILE__) . "/" . "ActivityService.php");
    $activityService = new ActivityService();
    if ($activityNo != "") {
        $activity = $activityService->getActivityByActivityNo($activityNo);
        echo json_encode($activity);
        exit;
    }
    if ($id != "") {
        if ($flag != "") {
            $activityService->updateActivityValidateFlag($id, $flag);
            echo '更新活动验证用户类型成功!';
        } else {
            $activityService->updateActivityTime($id);
            echo '更新活动时间成功!';
        }
    }
    if ($type != "") {
        $activityService->clearActivity();
        echo '清除活动数据成功!';
    }
    if ($id == "" && $type == "") {
        $activity = $activityService->getCurrentActivity();
        echo json_encode($activity);
    }
}