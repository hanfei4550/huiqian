<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-17
 * Time: 20:58
 */
class Token extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        $this->load->driver('cache');
        $this->cache->memcached->save('foo', 'bar', 10);
        $result = $this->cache->memcached->get('foo');
        echo $result;
    }
}