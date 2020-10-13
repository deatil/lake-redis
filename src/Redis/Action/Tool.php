<?php

namespace Lake\Redis\Action;

/**
 * 自定义的方法,用于简化操作
 */
class Tool
{
    private $redis;
    
    public function __construct($redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * redis事务
     * @param \Closure $closure
     */
    public function transaction(\Closure $closure)
    {
        $this->redis->multi();
        try {
            call_user_func($closure);
            if (!$this->redis->exec()) {
                $this->redis->discard();
            }
        } catch (Exception $e) {
            $this->redis->discard();
        }
    }

    /**
     * 获取所有到期数据
     *
     * @param  string $from
     * @param  int    $time
     * @return array
     */
    public function getExpiredDatas($from, $time)
    {
        return $this->redis->zRangeByScore($from, '-inf', $time);
    }

    /**
     * 删除过期数据
     *
     * @param  string $from
     * @param  int    $time
     * @return void
     */
    public function removeExpiredDatas($from, $time)
    {
        $this->redis->zRemRangeByScore($from, '-inf', $time);
    }
    
    /**
     * 得到一组的ID号
     * @param unknown $prefix
     * @param unknown $ids
     */
    public function hashAll($prefix, $ids)
    {
        if ($ids == false) {
            return false;
        }
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        
        $arr = [];
        foreach ($ids as $id) {
            $key = $prefix.'.'.$id;
            $res = $this->hGetAll($key);
            if ($res != false) {
                $arr[] = $res;
            }
        }
         
        return $arr;
    }
    
    /**
     * 生成一条消息，放在redis数据库中。
     * @param string|array $msg
     */
    public function pushMessage($lkey, $msg)
    {
        if (is_array($msg)) {
            $msg = json_encode($msg);
        }
        
        $key = md5($msg);
        
        // 如果消息已经存在，删除旧消息，已当前消息为准
        // 重新设置新消息
        $this->lPush($lkey, $key);
        $this->setex($key, $msg, 3600);
        return $key;
    }
    
    /**
     * 得到条批量删除key的命令
     * @param unknown $keys
     * @param unknown $dbId
     */
    public function delKeys($keys, $dbId)
    {
        $redisInfo = $this->getConnInfo();
        $cmdArr = [
            'redis-cli',
            '-a',
            $redisInfo['auth'],
            '-h',
            $redisInfo['host'],
            '-p',
            $redisInfo['port'],
            '-n',
            $dbId,
        ];
        $redisStr = implode(' ', $cmdArr);
        $cmd = "{$redisStr} KEYS \"{$keys}\" | xargs {$redisStr} del";
        return $cmd;
    }

}