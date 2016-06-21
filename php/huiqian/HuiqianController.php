<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-22
 * Time: 16:32
 */
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
//    $userId = "";
//    $activityId = "";
    $activityNo = "";
    $type = "0";
//    if (isset($_GET["userId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
//    {
//        $userId = $_GET['userId'];//存在
//    }
//
//    if (isset($_GET["activityId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
//    {
//        $activityId = $_GET['activityId'];//存在
//    }

    if (isset($_GET["activityNo"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $activityNo = $_GET['activityNo'];//存在
    }

    if (isset($_GET["type"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $type = $_GET['type'];//存在
    }

    if ($activityNo != "") {
        require_once(dirname(__FILE__) . "/" . "FansService.php");
        $fansService = new FansService();
        require_once(dirname(__FILE__) . "/" . "ActivityService.php");
        $activityService = new ActivityService();
        $activityArr = $activityService->getActivityByActivityNo($activityNo);
        if (count($activityArr) == 0) {
            $activityStr = json_encode($activityArr);
            echo $activityStr;
            exit;
        }
        $userId = $activityArr['user_id'];
        $activityId = $activityArr['activity_id'];
        if ($type == "1") {
            $fansPicArray = $fansService->getAlreadySignPeople($activityNo);
        } else {
            $fansPicArray = $fansService->getFansByUserAndActivity($userId, $activityId);
            if (count($fansPicArray) > 0) {
                foreach ($fansPicArray as $fansPic) {
                    $fansId = $fansPic["id"];
                    $fansService->updateSignStatus($userId, $activityId, $fansId);
                }
            }
        }
        $picStr = json_encode($fansPicArray);
        echo urldecode($picStr);
    }
}