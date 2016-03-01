<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-22
 * Time: 16:32
 */
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    $id = "";
    if (isset($_GET["id"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
    {
        $id = $_GET['id'];//存在
    }
    require_once(dirname(__FILE__) . "/" . "FansService.php");
    $fansService = new FansService();
    $fansService->removeBlacklist($id);
    echo "移除活动黑名单成功!";
}