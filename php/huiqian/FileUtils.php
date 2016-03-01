<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-10-31
 * Time: 23:09
 */
class FileUtils
{
    function download_remote_file($file_url, $save_to)
    {
        $content = file_get_contents($file_url);
        file_put_contents($save_to, $content);
    }

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

    function get_content($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function resizeHeadImageSize($headImageUrl, $size)
    {
        $length = strlen($headImageUrl);
        $pos = strrpos($headImageUrl, '/');
        $oldSize = substr($headImageUrl, $pos, $length - $pos);
        return str_replace($oldSize, ("/" . $size), $headImageUrl);
    }
}