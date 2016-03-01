<?php
$mysqli = new mysqli("localhost", "root", "hanfei", "huiqian");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$mysqli->query("set names utf-8");//设置字符集为utf-8
$userId = $_GET['userId'];
$activityId = $_GET['activityId'];
$stmt = $mysqli->prepare("select * from t_activitycenter_user_activity_fans where user_id=? and activity_id=?");
$stmt->bind_param('ss', $userId, $activityId);
$stmt->execute();
$stmt->bind_result($id, $user_id, $activity_id, $fans_id);
while ($stmt->fetch()) {
    echo "第" . $id . "条： " . $fans_id . "<br />";
}
$mysqli->close();//关闭与数据库的连接