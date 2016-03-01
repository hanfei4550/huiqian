<?php
$myArray = array();
$picArray = array();
$idArray = array();
$mysqli = new mysqli("localhost", "root", "hanfei", "huiqian");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$mysqli->query("set names utf-8");//
$userId = $_GET['userId'];
$activityId = $_GET['activityId'];
$stmt = $mysqli->prepare("SELECT f.id,f.nick,f.head_portraint FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? AND create_time < NOW() and status=0");
$stmt->bind_param('ss', $userId, $activityId);
$stmt->execute();
$stmt->bind_result($id, $nick, $head_portraint);

//先判断指定的路径是不是一个文件夹
while ($stmt->fetch()) {
    $filePath = "http://www.hn-coffeecat.cn/cmstest/images/huiqian/" . $head_portraint;
    $picArray["nick"] = $nick;
    $picArray["picUrl"] = $filePath;
    $myArray[] = $picArray;
    $idArray[] = $id;
}
$stmt->close();

foreach ($idArray as $fansId) {
    $stmt_result = $mysqli->prepare("update t_activitycenter_user_activity_fans set status=1 where user_id=? AND activity_id=? AND fans_id = ?");
    $stmt_result->bind_param('ddd',$userId, $activityId,$fansId);
    $stmt_result->execute();
}
$stmt_result->close();

$mysqli->close();//关闭与数据库的连接
$str = json_encode($myArray);
echo $str;