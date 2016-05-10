<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-22
 * Time: 16:32
 */
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $userId = "";
    $activityId = "";
    if (isset($_GET["userId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $userId = $_GET['userId'];//存在
    }

    if (isset($_GET["activityId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $activityId = $_GET['activityId'];//存在
    }

    if ($userId != "" && $activityId != "") {
        require_once(dirname(__FILE__) . "/" . "FansService.php");
        $fansService = new FansService();
        $fansPicArray = $fansService->getFansByUserAndActivity($userId, $activityId);
        if (count($fansPicArray) > 0) {
            foreach ($fansPicArray as $fansPic) {
                $fansId = $fansPic["id"];
                $fansService->updateSignStatus($userId, $activityId, $fansId);
            }
        }
        $picStr = json_encode($fansPicArray);
        echo urldecode($picStr);
    }
}