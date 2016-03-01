<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-10-22
 * Time: 21:45
 */
$id = $_GET['id'];
echo $id;
$nick = $_GET['nick'];
echo $nick;
$head_portraint = $_GET['head_portraint'];
echo $head_portraint;
$sex = $_GET['sex'];
echo $sex;
$con = mysql_connect("localhost", "root", "hanfei");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("huiqian", $con);
mysql_query("INSERT INTO t_usercenter_fans (ID, nick, head_portraint,sex) VALUES ('$id', '$nick', '$head_portraint','$sex')");
$result = mysql_query("SELECT * FROM t_usercenter_fans");
while ($row = mysql_fetch_array($result)) {
    echo "<br/>";
    echo $row['nick'] . " " . $row['head_portraint'] . " " . $row['sex'];
    echo "<br/>";
}
mysql_close($con);