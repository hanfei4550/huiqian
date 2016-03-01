<?php
/**
 * 获取用户的评论信息
 * User: coffeecat
 * Date: 2015-11-22
 * Time: 16:32
 */
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $userId = "";
    $activityId = "";
    $comment = "";
    $nick = "";
    if (isset($_GET["userId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $userId = $_GET['userId'];//存在
    }

    if (isset($_GET["activityId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $activityId = $_GET['activityId'];//存在
    }

    if (isset($_GET["comment"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $comment = $_GET['comment'];//存在
    }

    if (isset($_GET["nick"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $nick = $_GET['nick'];//存在
    }

    if ($userId != "" && $activityId != "") {
        require_once(dirname(__FILE__) . "/" . "FansService.php");
        $fansService = new FansService();
        if ($comment != "") {
            $fansId = $fansService->getFansIdByNick($nick);
            $fansService->insertFansMessage($fansId, $comment, $userId, $activityId);
        } else {
            $messageArray = $fansService->getRecentFansMessage($userId, $activityId);
            if (count($messageArray) > 0) {
                foreach ($messageArray as $message) {
                    $id = $message["id"];
                    $fansService->updateFansMessage($id);
                }
            }
            $resultMessage = json_encode($messageArray);
            echo urldecode($resultMessage);
        }
    }

}