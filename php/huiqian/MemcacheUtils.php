<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-21
 * Time: 11:14
 */
class MemcacheUtils
{
    public $mem;

    public function __construct()
    {
        $this->mem = new Memcache();
        $this->mem->connect('127.0.0.1', 11211);
    }

    public function add($key, $value, $timeout)
    {
        $this->mem->add($key, $value, MEMCACHE_COMPRESSED, $timeout);
    }

    public function get($key)
    {
        return $this->mem->get($key);
    }

}