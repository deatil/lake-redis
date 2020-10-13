<?php

namespace Lake\Redis\Data;

/**
 * 队列操作命令
 */
class List
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * 在队列尾部插入一个元素
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function rPush($key, $value)
    {
        return $this->redis->rPush($key, $value); 
    }
    
    /**
     * 在队列尾部插入一个元素 如果key不存在，什么也不做
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function rPushx($key, $value)
    {
        return $this->redis->rPushx($key, $value);
    }
    
    /**
     * 在队列头部插入一个元素
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function lPush($key, $value)
    {
        return $this->redis->lPush($key, $value);
    }
    
    /**
     * 在队列头插入一个元素 如果key不存在，什么也不做
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function lPushx($key, $value)
    {
        return $this->redis->lPushx($key, $value);
    }
    
    /**
     * 返回队列长度
     * @param unknown $key
     */
    public function lLen($key)
    {
        return $this->redis->lLen($key); 
    }
    
    /**
     * 返回队列指定区间的元素
     * @param unknown $key
     * @param unknown $start
     * @param unknown $end
     */
    public function lRange($key, $start, $end)
    {
        return $this->redis->lrange($key, $start, $end);
    }
    
    /**
     * 返回队列中指定索引的元素
     * @param unknown $key
     * @param unknown $index
     */
    public function lIndex($key, $index)
    {
        return $this->redis->lIndex($key, $index);
    }
    
    /**
     * 设定队列中指定index的值。
     * @param unknown $key
     * @param unknown $index
     * @param unknown $value
     */
    public function lSet($key, $index, $value)
    {
        return $this->redis->lSet($key, $index, $value);
    }
    
    /**
     * 删除值为vaule的count个元素
     * PHP-REDIS扩展的数据顺序与命令的顺序不太一样，不知道是不是bug
     * count>0 从尾部开始
     *  >0　从头部开始
     *  =0　删除全部
     * @param unknown $key
     * @param unknown $count
     * @param unknown $value
     */
    public function lRem($key, $count, $value)
    {
        return $this->redis->lRem($key, $value, $count);
    }
    
    /**
     * 删除并返回队列中的头元素。
     * @param unknown $key
     */
    public function lPop($key)
    {
        return $this->redis->lPop($key);
    }
    
    /**
     * 删除并返回队列中的尾元素
     * @param unknown $key
     */
    public function rPop($key)
    {
        return $this->redis->rPop($key);
    }

}