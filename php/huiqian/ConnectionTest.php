<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-10-29
 * Time: 17:20
 */
//为了解决方法调用传递中文参数乱码的问题
header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__) . "/" . "FansService.php");
require_once(dirname(__FILE__) . "/" . "ActivityService.php");
$fansService = new FansService();
$activityService = new ActivityService();

$userCount = $fansService->getUserCountByActivity(1,1);

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

//header("Location: http://www.hn-coffeecat.cn/huiqian/user-info.php?userId=$userId&activityId=$activityId&nick=".urlencode('韩飞'));
//
//exit;