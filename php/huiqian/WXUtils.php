<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-21
 * Time: 12:14
 */
require_once(dirname(__FILE__) . "/" . "FileUtils.php");
$config = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . "config.php");
$env = $config['env'];
//define('APP_ID', 'wxec230c866b34a22b');
//define('APP_SECRET', 'd40a6ee899991f07763f9a44af53b584');

define('APP_ID', $config[$env . '.' . 'appid']);
define('APP_SECRET', $config[$env . '.' . 'appsecret']);

class WXUtils
{
    //public $mem;

    public $fileUtils;

    public function __construct()
    {
        //$this->mem = new Memcache();
        $this->fileUtils = new FileUtils();
        //$this->mem->connect("127.0.0.1", 11211);
    }

    public function getToken($code)
    {
//        $token = $this->mem->get('wx_token');
//        if (!empty($token)) {
//            return $token;
//        }
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . APP_ID . '&secret=' . APP_SECRET . '&code=' . $code . '&grant_type=authorization_code';
        $tokenResult = $this->fileUtils->get_content($url);
        $token_json = json_decode($tokenResult, true);
//        $this->mem->set('wx_token', $token_json, 0, 7000);
        return $token_json;
    }

    public function getUserInfo($token)
    {
        $access_token = $token['access_token'];
        $openid = $token['openid'];
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $userInfoResult = $this->fileUtils->get_content($url);
        $userinfo_json = json_decode($userInfoResult, true);
//        if (isset($userinfo_json['errcode'])) {
//            sleep(2);
//            $userInfoResult = $this->fileUtils->get_content($url);
//            $userinfo_json = json_decode($userInfoResult, true);
//        }
        return $userinfo_json;
    }

    public function resizeHeadImage($headimgurl)
    {
        $headimgurl = $this->fileUtils->resizeHeadImageSize($headimgurl, 132);
        return $headimgurl;
    }
}