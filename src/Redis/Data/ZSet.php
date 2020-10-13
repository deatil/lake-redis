<?php

namespace Lake\Redis\Data;

/**
 * 有序集合操作
 */
class ZSet
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * 给当前集合添加一个元素
     * 如果value已经存在，会更新order的值。
     * @param string $key
     * @param string $order 序号
     * @param string $value 值
     * @return bool
     */
    public function zAdd($key, $order, $value)
    {
        return $this->redis->zAdd($key, $order, $value);
    }
    
    /**
     * 给$value成员的order值，增加$num,可以为负数
     * @param string $key
     * @param string $num 序号
     * @param string $value 值
     * @return 返回新的order
     */
    public function zinCry($key, $num, $value)
    {
        return $this->redis->zinCry($key, $num, $value);
    }
    
    /**
     * 删除值为value的元素
     * @param string $key
     * @param stirng $value
     * @return bool
     */
    public function zRem($key, $value)
    {
        return $this->redis->zRem($key, $value);
    }
    
    /**
     * 集合以order递增排列后，0表示第一个元素，-1表示最后一个元素
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array|bool
     */
    public function zRange($key, $start, $end)
    {
        return $this->redis->zRange($key, $start, $end);
    }
    
    /**
     * 集合以order递减排列后，0表示第一个元素，-1表示最后一个元素
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array|bool
     */
    public function zRevRange($key, $start, $end)
    {
        return $this->redis->zRevRange($key, $start, $end);
    }
    
    /**
     * 集合以order递增排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     * @param string $key
     * @param int $start
     * @param int $end
     * @package array $option 参数
     *     withscores => true，表示数组下标为Order值，默认返回索引数组
     *     limit => [0, 1] 表示从0开始，取一条记录。
     * @return array|bool
     */
    public function zRangeByScore(
        $key,
        $start = '-inf',
        $end = "+inf",
        $option = []
    ) {
        return $this->redis->zRangeByScore($key, $start, $end, $option);
    }
    
    /**
     * 集合以order递减排列后，返回指定order之间的元素。
     * min 和 max 可以是 -inf 和 +inf　表示最大值，最小值
     * @param string $key
     * @param int $start
     * @param int $end
     * @package array $option 参数
     *     withscores => true，表示数组下标为Order值，默认返回索引数组
     *     limit => [0, 1] 表示从0开始，取一条记录。
     * @return array|bool
     */
    public function zRevRangeByScore(
        $key,
        $start = '-inf',
        $end = "+inf",
        $option = []
    ) {
        return $this->redis->zRevRangeByScore($key, $start, $end, $option);
    }
    
    /**
     * 返回 order 值在 start、end 之间的数量
     * @param unknown $key
     * @param unknown $start
     * @param unknown $end
     */
    public function zCount($key, $start, $end)
    {
        return $this->redis->zCount($key, $start, $end);
    }
    
    /**
     * 返回值为value的order值
     * @param unknown $key
     * @param unknown $value
     */
    public function zScore($key, $value)
    {
        return $this->redis->zScore($key, $value);
    }
    
    /**
     * 返回集合以score递增加排序后，指定成员的排序号，从0开始。
     * @param unknown $key
     * @param unknown $value
     */
    public function zRank($key, $value)
    {
        return $this->redis->zRank($key, $value);
    }
    
    /**
     * 返回集合以score递增加排序后，指定成员的排序号，从0开始。
     * @param unknown $key
     * @param unknown $value
     */
    public function zRevRank($key, $value)
    {
        return $this->redis->zRevRank($key, $value);
    }
    
    /**
     * 删除集合中，score值在start end之间的元素　包括start end
     * min和max可以是-inf和+inf　表示最大值，最小值
     * @param unknown $key
     * @param unknown $start
     * @param unknown $end
     * @return 删除成员的数量。
     */
    public function zRemRangeByScore($key, $start, $end)
    {
        return $this->redis->zRemRangeByScore($key, $start, $end);
    }
    
    /**
     * 返回集合元素个数。
     * @param unknown $key
     */
    public function zCard($key)
    {
        return $this->redis->zCard($key);
    }

}