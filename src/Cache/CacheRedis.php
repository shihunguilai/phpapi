<?php

namespace shihunguilai\phpapi\Cache;

use Redis;
use Exception;
use shihunguilai\phpapi\Util\ApiUtil;

/**
 * Class CacheRedis.
 */
class CacheRedis
{
    private static $instance;
    /**
     * @var Redis
     */
    private $handler;
    /**
     * @var array()
     *              ******
     *              array(
     *              'host'=>'127.0.0.1',
     *'port'=>6379,
     *'timeout'=>false,
     *'persistent'=>false,
     * 'expire'=>0,
     * 'prefix'=>'',
     * 'persistent'=>false,
     * 'redis_auth'=>,
     * 'redis_db_num'=>,
     *
     *
     * )
     * ******
     */
    private $option;

    private function __construct(array $option)
    {
        $this->init($option);
    }
    private function __clone()
    {
    }

    private function init($option)
    {
        if (!extension_loaded('redis')) {
            throw new Exception('redis extension not installed');
        }
        $option = array_merge(array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'timeout' => false,
            'persistent' => false,
        ), $option);

        $this->option = $option;
        $this->option['expire'] = isset($option['expire']) ? $option['expire'] : 0;
        $this->option['prefix'] = isset($option['prefix']) ? $option['prefix'] : '';
        $this->option['length'] = isset($option['length']) ? $option['length'] : 0;
        $func = $option['persistent'] ? 'pconnect' : 'connect';
        $this->handler = new Redis();
        $option['timeout'] === false ?
            $this->handler->$func($option['host'], $option['port']) :
            $this->handler->$func($option['host'], $option['port'], $option['timeout']);

        if (!empty($option['redis_auth'])) {
            $this->handler->auth($option['redis_auth']);
        }

        if (!empty($option['redis_db_num'])) {
            $redis_db_num = $option['redis_db_num'];
            if (is_int($redis_db_num) && $redis_db_num) {
                $this->handler->select($redis_db_num);
            }
        }
    }

    public static function getInstance($option = [])
    {
        if (!(self::$instance && self::$instance instanceof self)) {
            self::$instance = new self($option);
        }

        return self::$instance;
    }

    /**
     * @param string | array $key
     *
     * @return string
     *                User:cliff zhang
     */
    public function getRealKey($key)
    {
        if (is_string($key)) {
            $ret = $this->option['prefix'].$key;
        } elseif (is_array($key)) {
            $ret = array_map(function ($v) {
                return $this->option['prefix'].$v;
            }, $key);
        } else {
            $ret = $this->option['prefix'].$key;
        }

        return $ret;
    }

    public function set($key, $value, $ttl = null)
    {
        if (is_null($ttl)) {
            $ttl = $this->option['expire'];
        }
        $key = $this->getRealKey($key);
        $value = ApiUtil::myserialize($value);
        if (is_int($ttl) && $ttl) {
            $res = $this->handler->setex($key, $ttl, $value);
        } else {
            $res = $this->handler->set($key, $value);
        }

        return $res;
    }

    /**
     * @param array $kvs
     *
     * @return mixed
     *               User:cliff zhang
     */
    public function mSet(array $kvs)
    {
        if (empty($kvs)) {
            return false;
        }
        $kvs_real = array_combine(
            $this->getRealKey(array_keys($kvs)),
            array_map(function ($v) {
                return ApiUtil::myserialize($v);
            }, array_values($kvs))
            );

        return $this->handler->mset($kvs_real);
    }

    /**
     * @param string $key
     *
     * @return mixed
     *               User:cliff zhang
     */
    public function get($key)
    {
        $key = $this->getRealKey($key);
        $rs = $this->handler->get($key);
        if ($rs) {
            return ApiUtil::myunserialize($rs);
        } else {
            return null;
        }
    }

    /**
     * @param array　$key
     *
     * @return mixed
     *               User:cliff zhang
     */
    public function mGet($key)
    {
        if (empty($key)) {
            return array();
        }
        $key_r = $this->getRealKey($key);
        $v_r = $this->handler->mget($key_r);
        if (empty($v_r)) {
            return null;
        }
        $rr = array_map(function ($v) {
            if (!$v) {
                return $v;
            }

            return ApiUtil::myunserialize($v);
        }, $v_r);

        return array_combine($key, array_values($rr));
    }

    /**
     * @param string | array $key
     *
     * @return bool
     *              2016年9月27日-下午10:33:02
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function rm($key)
    {
        if (empty($key)) {
            return false;
        }
        $key = $this->getRealKey($key);

        return $this->handler->del($key);
    }

    public function clear()
    {
        return $this->handler->flushDB();
    }
}
