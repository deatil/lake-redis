<?php

namespace Lake\Redis\Action;

/**
 * 事务
 */
class Transaction
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * 监控key,就是一个或多个key添加一个乐观锁
     * 在此期间如果key的值如果发生的改变，刚不能为key设定值
     * 可以重新取得Key的值。
     * @param unknown $key
     */
    public function watch($key)
    {
        return $this->redis->watch($key);
    }
    
    /**
     * 取消当前链接对所有key的watch
     *  EXEC 命令或 DISCARD 命令先被执行了的话，那么就不需要再执行 UNWATCH 了
     */
    public function unwatch()
    {
        return $this->redis->unwatch();
    }
    
    /**
     * 开启一个事务
     * 事务的调用有两种模式 Redis::MULTI 和 Redis::PIPELINE，
     * 默认是Redis::MULTI模式，
     * Redis::PIPELINE管道模式速度更快，但没有任何保证原子性有可能造成数据的丢失
     */
    public function multi($type = \Redis::MULTI)
    {
        return $this->redis->multi($type);
    }
    
    /**
     * 执行一个事务
     * 收到 EXEC 命令后进入事务执行，事务中任意命令执行失败，其余的命令依然被执行
     */
    public function exec()
    {
        return $this->redis->exec();
    }
    
    /**
     * 回滚一个事务
     */
    public function discard()
    {
        return $this->redis->discard();
    }

}