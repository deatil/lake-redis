<?php

namespace Lake\Redis\Data;

/**
 * redis字符串操作命令
 */
class String
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * 设置一个key
     * @param unknown $key
     * @param unknown $value
     */
    public function set($key, $value)
    {
        return $this->redis->set($key, $value);
    }
    
    /**
     * 得到一个key
     * @param unknown $key
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }
    
    /**
     * 设置一个有过期时间的key
     * @param unknown $key
     * @param unknown $value
     * @param unknown $expire
     */
    public function setex($key, $value, $expire = 3600)
    {
        return $this->redis->setex($key, $expire, $value);
    }
    
    /**
     * 设置一个key,如果key存在,不做任何操作.
     * @param unknown $key
     * @param unknown $value
     */
    public function setnx($key, $value)
    {
        return $this->redis->setnx($key, $value);
    }
    
    /**
     * 批量设置key
     * @param unknown $arr
     */
    public function mset($arr)
    {
        return $this->redis->mset($arr);
    }

}