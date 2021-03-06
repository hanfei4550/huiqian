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
        $currentDate = date("Ymd");
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        if ($activityId == '15') {
            $stmt = $conn->prepare("SELECT f.id,f.nick,f.head_portraint FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? and status=0 order by id asc limit 0,30");
        } else {
            $stmt = $conn->prepare("SELECT f.id,f.nick,f.head_portraint FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? and status=0 order by create_time asc limit 0,30");
        }
        $stmt->bind_param('ss', $userId, $activityId);
        $stmt->execute();
        $stmt->bind_result($id, $nick, $head_portraint);

        //先判断指定的路径是不是一个文件夹
        while ($stmt->fetch()) {
            $picArray["id"] = $id;
            $picArray["nick"] = $nick;
            $picArray["picUrl"] = $head_portraint;
            $myArray[] = $picArray;
        }

        $stmt->close();
        $conn->close();
        return $myArray;
    }

    function getFansHeadPortraintByNick($nick, $userId, $activityId)
    {
        $fansInfo = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("select uf.id,uf.head_portraint from t_usercenter_fans uf INNER JOIN t_activitycenter_user_activity_fans uaf ON uf.id= uaf.fans_id where nick=? and uaf.user_id=? and uaf.activity_id=?");
        $stmt->bind_param('sss', $nick, $userId, $activityId);
        $stmt->execute();
        $stmt->bind_result($fansId, $head_portraint);
        while ($stmt->fetch()) {
            $fansInfo['fansId'] = $fansId;
            $fansInfo['headImage'] = $head_portraint;
        }
        $stmt->close();
        $conn->close();
        return $fansInfo;
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

    function insertFans($nick, $head_portraint, $open_id)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("insert into t_usercenter_fans(nick,head_portraint,create_time,open_id) values(?,?,now(),?) ON DUPLICATE KEY UPDATE open_id=?,head_portraint=?,create_time=now()");
        $stmt->bind_param('sssss', $nick, $head_portraint, $open_id, $open_id, $head_portraint);
        $stmt->execute();
        $stmt->close();
        $newId = mysqli_insert_id($conn);
        $conn->close();
        return $newId;
    }

    function insertFansWithNameAndPhone($nick, $head_portraint, $name, $phone, $company, $job, $openId)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("insert into t_usercenter_fans(nick,head_portraint,name,phone,company,job,create_time,open_id) values(?,?,?,?,?,?,now(),?) ON DUPLICATE KEY UPDATE head_portraint=?");
        $stmt->bind_param('ssssssss', $nick, $head_portraint, $name, $phone, $company, $job, $openId, $head_portraint);
        $stmt->execute();
        $stmt->close();
        $newId = mysqli_insert_id($conn);
        $conn->close();
        return $newId;
    }

    function updateFans($name, $phone, $nick, $company, $job)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("update t_usercenter_fans set name=?,phone=?,company=?,job=? where nick=?");
        $stmt->bind_param('sssss', $name, $phone, $company, $job, $nick);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function getUserCountByActivity($userId, $activityId)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT COUNT(1) FROM t_activitycenter_user_activity_fans WHERE user_id=? AND activity_id=? AND order_num is not null");
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
        $stmt = $conn->prepare("insert into t_activitycenter_user_activity_fans(user_id,activity_id,fans_id,order_num) values(?,?,?,?) ON DUPLICATE KEY UPDATE order_num=?");
        $stmt->bind_param('ddddd', $userId, $activityId, $fansId, $orderNum, $orderNum);
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
        $currentDate = date(Ymd);
        while ($stmt->fetch()) {
            $picArray['id'] = $id;
            $picArray["nick"] = urlencode($nick);
            $picArray["picUrl"] = $head_portraint;
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
        $currentDate = date('Ymd');
        while ($stmt->fetch()) {
            $picArray["nick"] = urlencode($nick);
            $picArray["picUrl"] = $head_portraint;
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
        $stmt = $conn->prepare("SELECT m.id,nick,content FROM t_usercenter_fans_message m INNER JOIN t_usercenter_fans f ON m.fans_id= f.id WHERE user_id=? AND activity_id=? AND  STATUS=0 order by create_datetime ASC limit 0,5");
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


    function getMobileFansMessage($user_id, $activity_id)
    {
        $messageResult = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT m.id,nick,f.head_portraint,content FROM t_usercenter_fans_message m INNER JOIN t_usercenter_fans f ON m.fans_id= f.id WHERE user_id=? AND activity_id=? AND create_datetime >= now()-interval 5 second order by id desc limit 0,5");
        $stmt->bind_param('dd', $user_id, $activity_id);
        $stmt->execute();
        $stmt->bind_result($id, $nick, $headImage, $content);
        $messages = array();
        $currentDate = date('Ymd');
        while ($stmt->fetch()) {
            $messageResult['id'] = $id;
            $messageResult['nick'] = urlencode($nick);
            $messageResult['headImage'] = $headImage;
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

    function updateMobileFansMessage($id)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("update t_usercenter_fans_message set is_display_in_mobile=1 where id = ?");
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

    function getAllRegisterUserByActivity($activityId)
    {
        $myArray = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT f.name,f.phone FROM t_activitycenter_fans as f WHERE f.activity_id=?");
        $stmt->bind_param('s', $activityId);
        $stmt->execute();
        $stmt->bind_result($name, $phone);
        while ($stmt->fetch()) {
            $myArray[] = $name . ":" . $phone;
        }
        $stmt->close();
        $conn->close();
        return $myArray;
    }

    function getAlreadySignPeople($activityNo)
    {
        $myArray = array();
        $picArray = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT f.nick,f.head_portraint FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id inner join t_activitycenter_activity a on uaf.activity_id=a.id WHERE activity_no=? and uaf.status = 1");
        $stmt->bind_param('s', $activityNo);
        $stmt->execute();
        $stmt->bind_result($nick, $head_portraint);
        $currentDate = date('Ymd');
        while ($stmt->fetch()) {
            $picArray["nick"] = urlencode($nick);
            $picArray["picUrl"] = $head_portraint;
            $myArray[] = $picArray;
        }
        $stmt->close();
        $conn->close();
        return $myArray;
    }

    function getRegisterUserByParams($activityId, $name, $phone)
    {
        $myArray = array();
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("SELECT f.name,f.phone FROM t_activitycenter_fans as f WHERE f.activity_id=? and f.name=? and f.phone=?");
        $stmt->bind_param('sss', $activityId, $name, $phone);
        $stmt->execute();
        $stmt->bind_result($name, $phone);
        while ($stmt->fetch()) {
            $myArray[] = $name . ":" . $phone;
        }
        $stmt->close();
        $conn->close();
        return $myArray;
    }

}