<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-10-29
 * Time: 17:20
 */
//为了解决方法调用传递中文参数乱码的问题
header("Content-Type: text/html; charset=utf-8");

function str_split_unicode($str, $l = 0)
{
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function translate_nick($nickname)
{
    $resultNick = "";
    $results = str_split_unicode($nickname);
    $reg = '/[a-zA-Z0-9\[\]\x{4e00}-\x{9fa5}\s]+/u';
    foreach ($results as $result) {
        if (preg_match($reg, $result)) {
            $resultNick = $resultNick . $result;
        }
    }
    return trim($resultNick, " ");
}

$s = ' 王清平';

$nick = translate_nick($s);

echo $nick;


//require_once(dirname(__FILE__) . "/" . "FansService.php");
//require_once(dirname(__FILE__) . "/" . "ActivityService.php");
//$fansService = new FansService();
//$activityService = new ActivityService();
//
//$activity = $activityService->getCurrentActivity();
//echo $activity;

//$fansService->insertFansMessage(4, '祝福他');
//$messages = $fansService->getRecentFansMessage();
//echo count($messages);

//$fansArray = $fansService->getNewSignPeople(1, 1);
//echo count($fansArray);

//$activity = $activityService->getCurrentActivity();
//echo $activity['user_id'];
//echo $activity['activity_id'];

//$userId = 1;
//$activityId = 1;
//$fansResult = $fansService->getFansByUserAndActivity($userId, $activityId);
//$newFansId = $fansService->insertFans('zhuliu', '4.png');
//echo $newFansId;
//$fansService->updateFans('王五abcd', '18123538975', 'wangwu');
//$fansService->insertUserActivityFans($userId, $activityId, 4);

//$activityService = new ActivityService();
//$activity = $activityService->getCurrentActivity();
//print_r($activity);

//exit;