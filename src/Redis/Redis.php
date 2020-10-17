<?php

namespace Lake\Redis;

use Lake\Redis\Connect;

/**
 * redis 操作类
 * 注意：任何为false的串，存在redis中都是空串。
 * 只有在key不存在时，才会返回false。
 */
class Redis
{
    /**
     * 实例化的对象,单例模式.
     */
    private static $instance = [];
    
    /**
     * 得到实例化的对象.
     * 为每个数据库建立一个连接
     * 如果连接超时，将会重新建立一个连接
     * @param array $config
     * @param int $dbId
     */
    public static function getInstance($config, $attr = [])
    {
        // 如果是一个字符串，将其认为是数据库的ID号。以简化写法。
        if (!is_array($attr)) {
            $dbId = $attr;
            $attr = [];
            $attr['db_id'] = $dbId;
        }
        
        $attr['db_id'] = $attr['db_id'] ? intval($attr['db_id']) : 0;
        
        $k = md5(implode('', $config).$attr['db_id']);
        if (!isset(static::$instance[$k]) 
            || !(static::$instance[$k] instanceof Connect)
        ) {
            static::$instance[$k] = new Connect($config, $attr);
            static::$instance[$k]->withK($k);
            static::$instance[$k]->withDbId($attr['db_id']);
            
            //如果不是0号库，选择一下数据库。
            if ($attr['db_id'] != 0) {
                static::$instance[$k]->select($attr['db_id']);
            }
        } elseif (time() > static::$instance[$k]->getExpireTime()) {
            static::$instance[$k]->close();
            static::$instance[$k] = new Connect($config, $attr);
            static::$instance[$k]->withK($k);
            static::$instance[$k]->withDbId($attr['db_id']);
            
            //如果不是0号库，选择一下数据库。
            if ($attr['db_id'] != 0) {
                static::$instance[$k]->select($attr['db_id']);
            }
        }
        
        static::$instance[$k]->connectRedis();
        
        return static::$instance[$k];
    }
    
    /**
     * 关闭所有连接
     */
    public static function closeAll()
    {
        foreach (static::$instance as $redis) {
            if ($redis instanceof Connect) {
                $redis->close();
            }
        }
    }
    
    private function __clone(){}
}
