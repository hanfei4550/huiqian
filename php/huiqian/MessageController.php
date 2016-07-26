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
            $resultMessageArray = array();
            if (count($messageArray) > 0) {
                foreach ($messageArray as $message) {
                    $id = $message["id"];
                    $fansService->updateFansMessage($id);
                    $messageContent = urldecode($message['content']);
                    $log->warn("消息内容:" . $messageContent);
                    $log->warn("是否包含敏感词:" . is_contain_mingan_word($messageContent));
                    if (!is_contain_mingan_word($messageContent)) {
                        $resultMessageArray[] = $message;
                    }
                }
            }
            $resultMessage = json_encode($resultMessageArray);
            echo urldecode($resultMessage);
        }
    }

}

function getMinganWords()
{
    $file_path = "mingan-words.txt";
    $content = file_get_contents($file_path);
    $array = explode("\n", $content);
    return $array;
}


function is_contain_mingan_word($message)
{
    $minganwords = getMinganWords();
    for ($i = 0; $i < count($minganwords); $i++) {
        $position = strpos($message, $minganwords[$i]);
        if (!$position === FALSE || $message === $minganwords[$i]) {
            return true;
        }
    }
    return false;
}
