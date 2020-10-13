<?php

namespace Lake\Redis\Action;

/**
 * 发布
 */
class Publish
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    public function with($channel, $message)
    {
        return $this->redis->publish($channel, $message);
    }
}
