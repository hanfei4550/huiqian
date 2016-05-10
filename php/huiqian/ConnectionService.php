<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-10-29
 * Time: 17:12
 */
class ConnectionService
{
    var $host = "127.0.0.1";
    var $userName = "root";
    var $password = "yzqs1605";
    var $dbName = "huiqian";

    function getConnection()
    {
        $mysqli = new \mysqli($this->host, $this->userName, $this->password, $this->dbName);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        $mysqli->query("set names utf8");
        return $mysqli;
    }
}