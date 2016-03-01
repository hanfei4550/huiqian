<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-12
 * Time: 9:36
 */
function http_get_data($url)
{
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    ob_start ();
    curl_exec ( $ch );
    $return_content = ob_get_contents ();
    ob_end_clean ();
    $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
    return $return_content;
}

function download_file_by_curl($file_url,$save_to){
    $return_content = http_get_data($file_url);
    $fp= @fopen($save_to,"a"); //将文件绑定到流
    fwrite($fp,$return_content); //写入文件
}

$startTime = time();
$url  = 'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png';
$filename = '/var/www/html/cmstest/images/huiqian/2.png';
download_file_by_curl($url,$filename);
$costTime = time() - $startTime;
echo $costTime;