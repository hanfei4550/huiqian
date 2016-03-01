<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-1
 * Time: 11:09
 */
class RandomUtils
{
    function generate_random()
    {
        $a = mt_rand(10000000, 99999999);
        $b = mt_rand(10000000, 99999999);
        return $a . $b;
    }
}