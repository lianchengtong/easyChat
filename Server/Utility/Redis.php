<?php
namespace App\Utility;

use EasySwoole\Core\Component\Pool\PoolManager;

/**
 * Redis类
 * 在这里实现Redis方法
 */
class Redis
{
    /**
     * Redis连接池对象
     * @var object
     */
    protected static $redisPool;

    /**
     * redis对象
     * @var object
     */
    protected $redis;

    /**
     * 构造函数
     */
    public function __construct()
    {
        // 获取连接池对象
        if (!self::$redisPool instanceof RedisPool) {
            // 静态化的池不会被释放
            self::$redisPool = PoolManager::getInstance()->getPool(SysConst::REDIS_POOL_CLASS);
        }
        $this->redis = self::$redisPool->getObj();
    }

    /**
     * redis执行代理
     * @param  string $method redis命令
     * @param  mixed  $args   redis参数列表
     * @return string         redis 返回
     */
    public function exec($method, ...$args)
    {
        return $this->redis->exec($method, ...$args);
    }


    public function hSet($key, $field, $value)
    {
        return $this->redis->exec('hSet', $key, $field, $value);
    }

    public function hMset($key, $field, ...$value)
    {
        return $this->redis->exec('hMset', $key, $field, ...$value);
    }

    public function hGet($key, $field)
    {
        return $this->redis->exec('hGet', $key, $field);
    }

    public function hMget($key, $field, ...$value)
    {
        return $this->redis->exec('hMget', $key, $field, ...$value);
    }

    public function hGetAll($key)
    {
        return $this->redis->exec('hGetAll', $key);
    }

    public function hDel($key, ...$field)
    {
        return $this->redis->exec('hDel', $key, ...$field);
    }

    public function hExists($key, $field)
    {
        return $this->redis->exec('hExists', $key, $field);
    }

    public function hKeys($key)
    {
        return $this->redis->exec('hKeys', $key);
    }

    public function hVals($key)
    {
        return $this->redis->exec('hVals', $key);
    }

    public function sAdd($key, ...$member)
    {
        return $this->redis->exec('sAdd', $key, ...$member);
    }

    public function sRem($key, ...$member)
    {
        return $this->redis->exec('sRem', $key, ...$member);
    }

    public function sMembers($key)
    {
        return $this->redis->exec('smembers', $key);
    }

    public function sIsMember($key, $member)
    {
        return $this->redis->exec('sIsMember', $key, $member);
    }

    /**
     * 构析函数
     */
    public function __destruct()
    {
        // 释放连接池对象
        self::$redisPool->freeObj($this->redis);
    }
}
