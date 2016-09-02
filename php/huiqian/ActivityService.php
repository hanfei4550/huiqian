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
        date_default_timezone_set('UTC');
        $time = time();
        $date = date("Y-m-d", $time);
        $beginTime = $date . " 00:00:00";
        $endTime = $date . " 23:59:59";
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT user_id,activity_id,banner,is_validate_user,is_danmu FROM t_usercenter_user_activity ua INNER JOIN t_activitycenter_activity a ON ua.activity_id=a.id WHERE a.begin_time > ? AND a.end_time <= ?");
        $stmt->bind_param('ss', $beginTime, $endTime);
        $stmt->execute();
        $stmt->bind_result($user_id, $activity_id, $banner, $is_validate_user, $is_danmu);
        while ($stmt->fetch()) {
            $activityArray["user_id"] = $user_id;
            $activityArray["activity_id"] = $activity_id;
            $activityArray["banner"] = $banner;
            $activityArray["is_validate_user"] = $is_validate_user;
            $activityArray["is_danmu"] = $is_danmu;
        }
        $stmt->close();
        $conn->close();
        return $activityArray;
    }


    function getActivityByActivityNo($activityNo)
    {
        $activityArray = array();
        date_default_timezone_set('UTC');
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT user_id,activity_id,banner,is_validate_user,is_danmu,userinfo_url,signsuccess_url FROM t_usercenter_user_activity ua INNER JOIN t_activitycenter_activity a ON ua.activity_id=a.id WHERE a.activity_no = ?");
        $stmt->bind_param('s', $activityNo);
        $stmt->execute();
        $stmt->bind_result($user_id, $activity_id, $banner, $is_validate_user, $is_danmu, $userinfo_url, $signsuccess_url);
        while ($stmt->fetch()) {
            $activityArray["user_id"] = $user_id;
            $activityArray["activity_id"] = $activity_id;
            $activityArray["banner"] = $banner;
            $activityArray["is_validate_user"] = $is_validate_user;
            $activityArray["is_danmu"] = $is_danmu;
            $activityArray["userinfo_url"] = $userinfo_url;
            $activityArray["signsuccess_url"] = $signsuccess_url;
        }
        $stmt->close();
        $conn->close();
        return $activityArray;
    }

    function updateActivityTime($id)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $time = time();
        $date = date("Y-m-d", $time);
        $beginTime = $date . " 09:00:00";
        $endTime = $date . " 18:00:00";
        $stmt = $conn->prepare("update t_activitycenter_activity set begin_time=?,end_time=? where id=?");
        $stmt->bind_param('ssd', $beginTime, $endTime, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function updateActivityValidateFlag($id, $flag)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("update t_activitycenter_activity set is_validate_user=? where id=?");
        $stmt->bind_param('sd', $flag, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function clearActivity()
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("truncate table t_usercenter_fans");
        $stmt->execute();
        $stmt = $conn->prepare("truncate table t_usercenter_fans_message");
        $stmt->execute();
        $stmt = $conn->prepare("truncate table t_activitycenter_user_activity_fans");
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}