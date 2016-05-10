<?php

/**
 * Created by PhpStorm.
 * User: hanfei
 * Date: 16/4/26
 * Time: 下午2:49
 */
require_once(dirname(__FILE__) . "/" . "ConnectionService.php");

class UserDao
{
    function saveUser($name, $phone, $introduction, $mainBody)
    {
        $connManager = new ConnectionService();
        $conn = $connManager->getConnection();
        $stmt = $conn->prepare("insert into t_usercenter_user(name,phone,introduction,main_body) values(?,?,?,?)");
        $stmt->bind_param('ssss', $name, $phone, $introduction, $mainBody);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

}