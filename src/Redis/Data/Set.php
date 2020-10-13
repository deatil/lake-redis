<?php

namespace Lake\Redis\Data;

/**
 * redis无序集合操作命令
 */
class Set
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * 返回集合中所有元素
     * @param unknown $key
     */
    public function sMembers($key)
    {
        return $this->redis->sMembers($key);
    }
    
    /**
     * 求2个集合的差集
     * @param unknown $key1
     * @param unknown $key2
     */
    public function sDiff($key1, $key2)
    {
        return $this->redis->sDiff($key1, $key2);
    }
    
    /**
     * 添加集合。由于版本问题，扩展不支持批量添加。这里做了封装
     * @param unknown $key
     * @param string|array $value
     */
    public function sAdd($key, $value)
    {
        if (!is_array($value)) {
            $arr = [$value];
        } else {
            $arr = $value;
        }
        
        foreach ($arr as $row) {
            $this->redis->sAdd($key, $row);
        }
    }
    
    /**
     * 返回无序集合的元素个数
     * @param unknown $key
     */
    public function scard($key)
    {
        return $this->redis->scard($key);
    }
    
    /**
     * 从集合中删除一个元素
     * @param unknown $key
     * @param unknown $value
     */
    public function srem($key,$value)
    {
        return $this->redis->srem($key,$value);
    }

}