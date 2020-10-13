<?php

namespace Lake\Redis\Action;

/**
 * IncrDecr
 */
class IncrDecr
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * Redis Incr 命令将 key 中储存的数字值增一。
     * > Incr KEY_NAME
     */
    public function incr($keyName)
    {
        return $this->redis->incr($keyName);
    }
    
    /**
     * Redis Incrby 命令将 key 中储存的数字加上指定的增量值。
     * > Incrby KEY_NAME INCR_AMOUNT
     */
    public function incrby($keyName, $incrAmount)
    {
        return $this->redis->incrby($keyName, $incrAmount);
    }
    
    /**
     * Redis Incrbyfloat 命令为 key 中所储存的值加上指定的浮点数增量值。
     * > INCRBYFLOAT KEY_NAME INCR_AMOUNT
     */
    public function incrbyfloat($keyName, $incrAmount)
    {
        return $this->redis->incrbyfloat($keyName, $incrAmount);
    }
    
    /**
     * Redis Decr 命令将 key 中储存的数字值减一。
     * > DECR KEY_NAME 
     */
    public function decr($keyName)
    {
        return $this->redis->decr($keyName);
    }
    
    /**
     * Redis Decrby 命令将 key 所储存的值减去指定的减量值。
     * > DECRBY KEY_NAME DECREMENT_AMOUNT
     */
    public function decrby($keyName, $incrAmount)
    {
        return $this->redis->decrby($keyName, $incrAmount);
    }
    
    /**
     * Redis Append 命令用于为指定的 key 追加值。
     * > APPEND KEY_NAME NEW_VALUE
     */
    public function append($keyName, $newValue)
    {
        return $this->redis->append($keyName, $newValue);
    }
}
