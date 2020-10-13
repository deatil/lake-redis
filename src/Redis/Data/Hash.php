<?php

namespace Lake\Redis\Data;

/**
 * hash表操作函数
 */
class Hash
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * 得到hash表中一个字段的值
     * @param string $key 缓存key
     * @param string $field 字段
     * @return string|false
     */
    public function hGet($key, $field)
    {
        return $this->redis->hGet($key, $field);
    }
    
    /**
     * 为hash表设定一个字段的值
     * @param string $key 缓存key
     * @param string  $field 字段
     * @param string $value 值。
     * @return bool 
     */
    public function hSet($key, $field, $value)
    {
        return $this->redis->hSet($key,$field,$value);
    }
    
    /**
     * 判断hash表中，指定field是不是存在
     * @param string $key 缓存key
     * @param string  $field 字段
     * @return bool
     */
    public function hExists($key, $field)
    {
        return $this->redis->hExists($key, $field);
    }
    
    /**
     * 删除hash表中指定字段 ,支持批量删除
     * @param string $key 缓存key
     * @param string  $field 字段
     * @return int
     */
    public function hdel($key, $field)
    {
        if (!is_array($field)) {
            $field = explode(',', $field);
        }
        
        $delNum = 0;
 
        foreach ($field as $row) {
            $row = trim($row);
            $delNum += $this->redis->hDel($key, $row);
        }
 
        return $delNum;
    }
    
    /**
     * 返回hash表元素个数
     * @param string $key 缓存key
     * @return int|bool
     */
    public function hLen($key)
    {
        return $this->redis->hLen($key);
    }
    
    /**
     * 为hash表设定一个字段的值,如果字段存在，返回false
     * @param string $key 缓存key
     * @param string $field 字段
     * @param string $value 值。
     * @return bool
     */
    public function hSetNx($key, $field, $value)
    {
        return $this->redis->hSetNx($key, $field, $value);
    }
    
    /**
     * 为hash表多个字段设定值。
     * @param string $key
     * @param array $value
     * @return array|bool
     */
    public function hMset($key, $value)
    {
        if (!is_array($value)) {
            return false;
        }
        
        return $this->redis->hMset($key, $value); 
    }
    
    /**
     * 获取多个字段设定值。
     * @param string $key
     * @param array|string $value string以','号分隔字段
     * @return array|bool
     */
    public function hMget($key, $field)
    {
        if (!is_array($field)) {
            $field = explode(',', $field);
        }
        
        return $this->redis->hMget($key,$field);
    }
    
    /**
     * 为hash表设这累加，可以负数
     * @param string $key
     * @param int $field
     * @param string $value
     * @return bool
     */
    public function hIncrBy($key, $field, $value)
    {
        $value = intval($value);
        return $this->redis->hIncrBy($key, $field, $value);
    }
    
    /**
     * 返回所有hash表的所有字段
     * @param string $key
     * @return array|bool
     */
    public function hKeys($key)
    {
        return $this->redis->hKeys($key);
    }
    
    /**
     * 返回所有hash表的字段值，为一个索引数组
     * @param string $key
     * @return array|bool
     */
    public function hVals($key)
    {
        return $this->redis->hVals($key);
    }
    
    /**
     * 返回所有hash表的字段值，为一个关联数组
     * @param string $key
     * @return array|bool
     */
    public function hGetAll($key)
    {
        return $this->redis->hGetAll($key);
    }

}