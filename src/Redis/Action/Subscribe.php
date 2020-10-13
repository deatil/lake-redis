<?php

namespace Lake\Redis\Action;

use Closure;

/**
 * 订阅
 */
class Subscribe
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * 获取所有到期数据
     *
     * @param array $channels
     * @param Closure $callback
     * @return array
     */
    public function with(array $channels, Closure $callback)
    {
        return $this->redis->subscribe($channels, $callback);
    }
}
