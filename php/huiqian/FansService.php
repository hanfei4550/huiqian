<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-10-29
 * Time: 17:43
 */

require_once(dirname(__FILE__) . "/" . "ConnectionService.php");

class FansService
{
    function getFansByUserAndActivity($userId, $activityId)
    {
        $myArray = array();
        $picArray = array();

        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT f.id,f.nick,f.head_portraint FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? AND create_time < NOW() and status=0");
        $stmt->bind_param('ss', $userId, $activityId);
        $stmt->execute();
        $stmt->bind_result($id, $nick, $head_portraint);

        //先判断指定的路径是不是一个文件夹
        while ($stmt->fetch()) {
            $filePath = "http://www.hn-coffeecat.cn/cmstest/images/huiqian/" . $head_portraint;
            $picArray["id"] = $id;
            $picArray["nick"] = $nick;
            $picArray["picUrl"] = $filePath;
            $myArray[] = $picArray;
        }

        $stmt->close();
        $conn->close();
        return $myArray;
    }

    function getFansHeadPortraintByNick($nick)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("select head_portraint from t_usercenter_fans where nick=?");
        $stmt->bind_param('s', $nick);
        $stmt->execute();
        $stmt->bind_result($head_portraint);
        $headImage = "";
        while ($stmt->fetch()) {
            $headImage = $head_portraint;
        }
        $stmt->close();
        $conn->close();
        return $headImage;
    }

    function getFansIdByNick($nick)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("select id from t_usercenter_fans where nick=?");
        $stmt->bind_param('s', $nick);
        $stmt->execute();
        $stmt->bind_result($id);
        $fansId = "";
        while ($stmt->fetch()) {
            $fansId = $id;
        }
        $stmt->close();
        $conn->close();
        return $fansId;
    }

    function getOrderNumByUser($user_id, $activity_id, $fans_id)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT order_num FROM t_activitycenter_user_activity_fans WHERE user_id=? AND activity_id=? and fans_id=?");
        $stmt->bind_param('ssd', $user_id, $activity_id, $fans_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $ucount = 0;
        while ($stmt->fetch()) {
            $ucount = $count;
        }
        $stmt->close();
        $conn->close();
        return $ucount;
    }

    function insertFans($nick, $head_portraint)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("insert into t_usercenter_fans(nick,head_portraint,create_time) values(?,?,now()) ON DUPLICATE KEY UPDATE head_portraint=?");
        $stmt->bind_param('sss', $nick, $head_portraint, $head_portraint);
        $stmt->execute();
        $stmt->close();
        $newId = mysqli_insert_id($conn);
        $conn->close();
        return $newId;
    }

    function updateFans($name, $phone, $nick)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("update t_usercenter_fans set name=?,phone=? where nick=?");
        //echo $name;
        //echo $phone;
        //echo $nick;
        $stmt->bind_param('sss', $name, $phone, $nick);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function getUserCountByActivity($userId, $activityId)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT COUNT(1) FROM t_activitycenter_user_activity_fans WHERE user_id=? AND activity_id=?");
        $stmt->bind_param('ss', $userId, $activityId);
        $stmt->bind_result($count);
        $stmt->execute();
        $userCount = 0;
        while ($stmt->fetch()) {
            $userCount = $count + 1;
        }
        $stmt->close();
        $conn->close();
        return $userCount;
    }

    function insertUserActivityFans($userId, $activityId, $fansId, $orderNum)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("insert into t_activitycenter_user_activity_fans(user_id,activity_id,fans_id,order_num) values(?,?,?,?)");
        $stmt->bind_param('dddd', $userId, $activityId, $fansId, $orderNum);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function getNewSignPeople($userId, $activityId)
    {
        $myArray = array();
        $picArray = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT f.id,f.nick,f.head_portraint FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? AND create_time < NOW() and status=0");
        $stmt->bind_param('ss', $userId, $activityId);
        $stmt->execute();
        $stmt->bind_result($id, $nick, $head_portraint);
        while ($stmt->fetch()) {
            $filePath = "http://www.hn-coffeecat.cn/cmstest/images/huiqian/" . $head_portraint;
            $picArray['id'] = $id;
            $picArray["nick"] = urlencode($nick);
            $picArray["picUrl"] = $filePath;
            $myArray[] = $picArray;
        }
        $stmt->close();
        $conn->close();
        return $myArray;
    }

    function getAllPeopleByActivity($userId, $activityId)
    {
        $myArray = array();
        $picArray = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT f.nick,f.head_portraint FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=?");
        $stmt->bind_param('ss', $userId, $activityId);
        $stmt->execute();
        $stmt->bind_result($nick, $head_portraint);
        while ($stmt->fetch()) {
            $filePath = "http://www.hn-coffeecat.cn/cmstest/images/huiqian/" . $head_portraint;
            $picArray["nick"] = urlencode($nick);
            $picArray["picUrl"] = $filePath;
            $myArray[] = $picArray;
        }
        $stmt->close();
        $conn->close();
        return $myArray;
    }


    function updateSignStatus($userId, $activityId, $fansId)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("update t_activitycenter_user_activity_fans set status=1 where user_id=? AND activity_id=? AND fans_id = ?");
        $stmt->bind_param('ddd', $userId, $activityId, $fansId);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function insertFansMessage($fansId, $content, $userId, $activityId)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("insert into  t_usercenter_fans_message(fans_id,content,create_datetime,user_id,activity_id) values(?,?,now(),?,?)");
        $stmt->bind_param('dsdd', $fansId, $content, $userId, $activityId);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function getRecentFansMessage($user_id, $activity_id)
    {
        $messageResult = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT m.id,nick,content FROM t_usercenter_fans_message m INNER JOIN t_usercenter_fans f ON m.fans_id= f.id WHERE user_id=? AND activity_id=? AND  STATUS=0 AND create_datetime <= NOW()");
        $stmt->bind_param('dd', $user_id, $activity_id);
        $stmt->execute();
        $stmt->bind_result($id, $nick, $content);
        $messages = array();
        while ($stmt->fetch()) {
            $messageResult['id'] = $id;
            $messageResult['nick'] = urlencode($nick);
            $messageResult['content'] = urlencode($content);
            $messages[] = $messageResult;
        }
        $stmt->close();
        $conn->close();
        return $messages;
    }

    function updateFansMessage($id)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("update t_usercenter_fans_message set status=1  where id = ? and create_datetime <= now()");
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function getFansByCondition($condition, $pageNo, $pageSize, $userId, $activityId)
    {
        $myArray = array();
        $picArray = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
//        var_dump($condition);
//        echo array_key_exists("name",$condition);
        if (array_key_exists('nick', $condition) && array_key_exists('name', $condition)) {
            $nick = $condition['nick'];
            $name = $condition['name'];
            $stmt = $conn->prepare("SELECT f.id,f.nick,f.name FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? and nick=? and name=? limit ?,?");
            $stmt->bind_param('ssssdd', $userId, $activityId, $nick, $name, $pageNo, $pageSize);
        } else if (array_key_exists('nick', $condition)) {
            $nick = $condition['nick'];
            $stmt = $conn->prepare("SELECT f.id,f.nick,f.name FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? and nick=? limit ?,?");
            $stmt->bind_param('sssdd', $userId, $activityId, $nick, $pageNo, $pageSize);
        } else if (array_key_exists('name', $condition)) {
            $name = $condition['name'];
            $stmt = $conn->prepare("SELECT f.id,f.nick,f.name FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? and name=? limit ?,?");
            $stmt->bind_param('sssdd', $userId, $activityId, $name, $pageNo, $pageSize);
        } else {
            $stmt = $conn->prepare("SELECT f.id,f.nick,f.name FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? limit ?,?");
            $stmt->bind_param('ssdd', $userId, $activityId, $pageNo, $pageSize);
        }
        $stmt->execute();
        $stmt->bind_result($id, $nick, $name);
        while ($stmt->fetch()) {
            $picArray['id'] = $id;
            $picArray["nick"] = urlencode($nick);
            $picArray["name"] = urlencode($name);
            $myArray[] = $picArray;
        }
        $stmt->close();
        $conn->close();
        return $myArray;
    }

    function addBlacklist($fansId, $nick, $name, $userId, $activityId)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("insert into  t_usercenter_blacklist(fans_id,nick,name,user_id,activity_id) values(?,?,?,?,?)");
        $stmt->bind_param('dssdd', $fansId, $nick, $name, $userId, $activityId);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function removeBlacklist($id)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("delete from t_usercenter_blacklist where id = ?");
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function getBlacklistByActivity($userId, $activityId)
    {
        $myArray = array();
        $picArray = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT id,nick,name FROM t_usercenter_blacklist WHERE user_id=? AND activity_id=?");
        $stmt->bind_param('dd', $userId, $activityId);
        $stmt->execute();
        $stmt->bind_result($id, $nick, $name);
        while ($stmt->fetch()) {
            $picArray['id'] = $id;
            $picArray["nick"] = urlencode($nick);
            $picArray["name"] = urlencode($name);
            $myArray[] = $picArray;
        }
        $stmt->close();
        $conn->close();
        return $myArray;
    }
}