<?php
/**
 * Created by PhpStorm.
 * User: hanfei
 * Date: 16/5/19
 * Time: 上午11:04
 */
if (is_array($_GET) && count($_GET) > 0)//判断是否有Get参数
{
    if (isset($_GET["url"])) {
        $url = urldecode($_GET['url']);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://dwz.cn/create.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = array('url' => $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $strRes = curl_exec($ch);
    curl_close($ch);
    echo $strRes;
//    $arrResponse = json_decode($strRes, true);
//    if ($arrResponse['status'] == 0) {
//        /**错误处理*/
//        echo iconv('UTF-8', 'GBK', $arrResponse['err_msg']);
//    }
//    /** tinyurl */
//    echo $arrResponse['tinyurl'];
}