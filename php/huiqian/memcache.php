<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-1
 * Time: 9:58
 */
$mem = new Memcache;
$mem->connect("127.0.0.1", 11211);
$mem->set('key','This is a test!', 0, 60);
$val = $mem->get('key');
echo $val;
