<?php

namespace Lake\Redis;

/**
 * redis
 *
 */
class Connect
{
    // 配置
    protected $config = [
        // 地址
        'host' => '127.0.0.1',
        // 端口
        'port' => 6379,
        // 当前权限认证码
        'auth' => '',
        // 是否使用长连接 false or true
        'persistent' => false,
        // 连接超时时间，redis配置文件中默认为300秒
        'timeout' => 300,
    ];
    
    private $redis;
    
    // 当前数据库ID号
    protected $dbId = 0;
    
    // 什么时候重新建立连接
    protected $expireTime;
    
    // 当前连接的KEY
    private $k;
    
    public function __construct($config = [])
    {
        $this->withConfig($config);
    }
    
    /**
     * 连接redis
     */
    public function connectRedis()
    {
        $this->redis = new \Redis();
        
        $this->port = $this->config['port'];
        $this->host = $this->config['host'];
        
        $func = $this->config['persistent'] ? 'pconnect' : 'connect';
        
        $this->redis->$func($this->host, $this->port, $this->config['timeout']);
        
        if ($this->config['auth']) {
            $this->redis->auth($this->config['auth']);
        }
        
        $this->expireTime = time() + $this->config['timeout'];
    }
    
    /**
     * 执行原生的redis操作
     * @return \Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }
    
    /**
     * 设置配置信息
     */
    public function withConfig($config = [])
    {
        $this->config = array_merge($this->config, $config);
        return $this;
    }
    
    /**
     * 获取配置信息
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    public function withDbId($dbId)
    {
        $this->dbId = $dbId;
        return $this;
    }
    
    /**
     * 得到当前数据库ID
     * @return int
     */
    public function getDbId()
    {
        return $this->dbId;
    }
    
    public function withK($k)
    {
        $this->k = $k;
        return $this;
    }
    
    public function getK()
    {
        return $this->k;
    }
    
    public function getExpireTime()
    {
        return $this->expireTime;
    }
    
    /**
     * 关闭服务器链接
     */
    public function close()
    {
        return $this->redis->close();
    }
    
    public function auth($auth)
    {
        return $this->redis->auth($auth);
    }
    
    /**
     * 选择数据库
     * @param int $dbId 数据库ID号
     * @return bool
     */
    public function select($dbId)
    {
        return $this->redis->select($dbId);
    }
    
    /**
     * 清空当前数据库
     * @return bool
     */
    public function flushDB()
    {
        return $this->redis->flushDB();
    }
    
    /**
     * 测试当前链接是不是已经失效
     * 没有失效返回+PONG
     * 失效返回false
     */
    public function ping()
    {
        return $this->redis->ping();
    }

    /**
     * 运行redis命令.
     *
     * @param string $command
     * @return mixed
     */
    public function execute($command)
    {
        $command = explode(' ', $command);

        return $this->redis->executeRaw($command);
    }
    
    /**
     * 返回当前库状态
     * @return array
     */
    public function info()
    {
        return $this->redis->info();
    }
    
    /**
     * 同步保存数据到磁盘
     */
    public function save()
    {
        return $this->redis->save();
    }
    
    /**
     * 异步保存数据到磁盘
     */
    public function bgSave()
    {
        return $this->redis->bgSave();
    }
    
    /**
     * 返回最后保存到磁盘的时间
     */
    public function lastSave()
    {
        return $this->redis->lastSave();
    }
    
    /**
     * 返回key所存储值的类型
     * @param string $key
     * @return string
     */
    public function type($key)
    {
        return $this->redis->type($key);
    }
    
    /**
     * 序列化给定的key，并返回被序列化的值
     * @param string $key
     * @return string
     */
    public function dump($key)
    {
        return $this->redis->dump($key);
    }
    
    /**
     * 返回key,支持*多个字符，?一个字符
     * 只有*　表示全部
     * @param string $key
     * @return array
     */
    public function keys($key)
    {
        return $this->redis->keys($key);
    }
    
    /**
     * 返回key数据
     * @param string $key
     * @return array|string
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }
    
    /**
     * 删除指定key
     * @param unknown $key
     */
    public function del($key)
    {
        return $this->redis->del($key);
    }
    
    /**
     * 判断一个key值是不是存在
     * @param unknown $key
     */
    public function exists($key)
    {
        return $this->redis->exists($key);
    }
    
    /**
     * 修改key名称
     * @param string $oldKeyName
     * @param string $newKeyName
     */
    public function rename($oldKeyName, $newKeyName)
    {
        return $this->redis->rename($oldKeyName, $newKeyName);
    }
    
    /**
     * 仅当 newKeyName 不存在时 修改key名称
     * @param string $oldKeyName
     * @param string $newKeyName
     */
    public function renamenx($oldKeyName, $newKeyName)
    {
        return $this->redis->renamenx($oldKeyName, $newKeyName);
    }
    
    /**
     * 将 keyName 移动到给定数据库中
     * @param string $keyName
     * @param string $destinationDatabase
     */
    public function move($keyName, $destinationDatabase)
    {
        return $this->redis->move($keyName, $destinationDatabase);
    }
    
    /**
     * 移除KEY的过期时间
     * @param unknown $keyName
     */
    public function persist($keyName)
    {
        return $this->redis->persist($keyName);
    }
    
    /**
     * 为一个key设定过期时间 单位为秒
     * @param unknown $key
     * @param unknown $expire
     */
    public function expire($key, $expire)
    {
        return $this->redis->expire($key, $expire);
    }
    
    /**
     * 返回一个key还有多久过期，单位秒
     * @param unknown $key
     */
    public function ttl($key)
    {
        return $this->redis->ttl($key);
    }
    
    /**
     * 设定一个key什么时候过期，time为一个时间戳
     * @param unknown $key
     * @param unknown $time
     */
    public function exprieAt($key, $time)
    {
        return $this->redis->expireAt($key, $time);
    }
    
    /**
     * 返回当前数据库key数量
     */
    public function dbSize()
    {
        return $this->redis->dbSize();
    }
    
    /**
     * 返回一个随机key
     */
    public function randomKey()
    {
        return $this->redis->randomKey();
    }
    
    public function __destruct()
    {
        // 这里不关闭连接，因为session写入会在所有对象销毁之后。
        // return $this->redis->close();
    }
}
