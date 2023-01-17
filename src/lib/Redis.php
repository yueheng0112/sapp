<?php

namespace sapp\lib;

class Redis extends \Redis
{
    public static function instance($config)
    {
        $config = is_array($config) ? $config : config($config);
        $redis  = new static();
        $redis->connect($config['host'], $config['port'], 3);
        $redis->auth($config['password']);
        $redis->select(intval($config['select']));
        return $redis;
    }

    public function getType($key)
    {
        $type = $this->type($key);
        switch ($type) {
            case \Redis::REDIS_STRING:
                $name = 'string';
                break;
            case \Redis::REDIS_HASH:
                $name = 'hash';
                break;
            case \Redis::REDIS_LIST:
                $name = 'list';
                break;
            case \Redis::REDIS_SET:
                $name = 'set';
                break;
            case \Redis::REDIS_ZSET:
                $name = 'zset';
                break;
            default:
                $name = 'unkown';
                break;
        }
        return $name;
    }

    public function getLength($key)
    {
        $type = $this->type($key);
        switch ($type) {
            case \Redis::REDIS_STRING:
                $length = 1;
                break;
            case \Redis::REDIS_HASH:
                $length = $this->hLen($key);
                break;
            case \Redis::REDIS_LIST:
                $length = $this->lLen($key);
                break;
            case \Redis::REDIS_SET:
                $length = $this->sCard($key);
                break;
            case \Redis::REDIS_ZSET:
                $length = $this->zCard($key);
                break;
            default:
                $length = 0;
                break;
        }
        return $length;
    }
}