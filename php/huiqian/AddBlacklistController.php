<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-22
 * Time: 16:32
 */
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $userId = "";
    $activityId = "";
    $fansId = "";
    $nick = "";
    $name = "";
    if (isset($_GET["userId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $userId = $_GET['userId'];//存在
    }
    if (isset($_GET["activityId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $activityId = $_GET['activityId'];//存在
    }
    if (isset($_GET["fansId"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $fansId = $_GET['fansId'];
    }
    if (isset($_GET["nick"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $nick = urldecode($_GET["nick"]);//存在
    }
    if (isset($_GET["name"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $name = urldecode($_GET['name']);//存在
    }
    require_once(dirname(__FILE__) . "/" . "FansService.php");
    $fansService = new FansService();
    $fansService->addBlacklist($fansId, $nick, $name, $userId, $activityId);
    echo "保存活动黑名单成功!";
}