<?php
/**
 * Created by PhpStorm.
 * User: hanfei
 * Date: 16/4/26
 * Time: 下午2:58
 */
if (is_array($_POST) && count($_POST) > 0)//判断是否有Get参数
{
    $name = "";
    $phone = "";
    $introduction = "";
    $type = "";
    $mainBody = "";
    if (isset($_POST["name"])) {
        $name = $_POST['name'];
    }
    if (isset($_POST["phone"])) {
        $phone = $_POST['phone'];
    }
    if (isset($_POST["company"])) {
        $introduction = $_POST['company'];
    }
    if (isset($_POST["type"])) {
        $type = $_POST['type'];
    }
    if (isset($_POST["mainBody"])) {
        $mainBody = $_POST['mainBody'];
    }
    require_once(dirname(__FILE__) . "/" . "UserDao.php");
    $userDao = new UserDao();
    if ($type == "save") {
        $userDao->saveUser($name, $phone, $introduction, $mainBody);
        echo "success";
        exit;
    }
    echo "error";
    exit;
}