<?php

namespace Lake\Redis\Data;

/**
 * Bitmap
 */
class Bitmap
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**    
     * 设置位图    
     * @param $key    
     * @param $offset    
     * @param $value    
     * @param int $time    
     * @return int|null    
     * @throws \Exception    
     */  
    public function setBit($key, $offset, $value, $time = 0) 
    {
        $result = $this->redis->setBit($key, $offset, $value);
        if ($time) {
            $this->redis->expire($key, $time);
        }
        
        return $result;
    }   
    
    /**    
     * 获取位图    
     * @param $key    
     * @param $offset    
     * @return int|null    
     * @throws \Exception    
     */
    public function getBit($key, $offset)
    {
        return $this->redis->getBit($key, $offset);
    }   
    
    /**
     * 统计位图
     * @param $key
     * @return int|null
     * @throws \Exception
     */
    public function bitCount($key)
    {
        return $this->redis->bitCount($key);
    }

    /**
     * 位图操作
     * @param $operation
     * @param $retKey
     * @param mixed ...$key
     * @return int|null
     * @throws \Exception
     */ 
    public function bitOp($operation, $retKey, ...$key)
    {
        return $this->redis->bitOp($operation, $retKey, $key);
    }   
    
    /**
     * 计算在某段位图中 1或0第一次出现的位置
     * @param $key
     * @param $bit 1/0
     * @param $start
     * @param null $end
     * @return int|null
     * @throws \Exception
     */  
    public function bitPos($key, $bit, $start, $end = null)
    {     
        return $this->redis->bitpos($key, $bit, $start, $end);
    }   
    
    /**
     * 删除数据
     * @param $key
     * @return int|null
     * @throws \Exception
     */  
    public function del($key)
    {     
        return $this->redis->del($key);
    } 
}
