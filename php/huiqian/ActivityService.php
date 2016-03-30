<?php

require_once(dirname(__FILE__) . "/" . "ConnectionService.php");

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-1
 * Time: 14:16
 */
class ActivityService
{
    function getCurrentActivity()
    {
        $activityArray = array();
        $time = time();
        $date = date("Y-m-d", $time);
        $beginTime = $date . " 00:00:00";
        $endTime = $date . " 23:59:59";
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT user_id,activity_id,banner FROM t_usercenter_user_activity ua INNER JOIN t_activitycenter_activity a ON ua.activity_id=a.id WHERE a.begin_time > ? AND a.end_time <= ?");
        $stmt->bind_param('ss', $beginTime, $endTime);
        $stmt->execute();
        $stmt->bind_result($user_id, $activity_id,$banner);
        while ($stmt->fetch()) {
            $activityArray["user_id"] = $user_id;
            $activityArray["activity_id"] = $activity_id;
            $activityArray["banner"] = $banner;
        }
        $stmt->close();
        $conn->close();
        return $activityArray;
    }
}