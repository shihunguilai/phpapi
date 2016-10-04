<?php

namespace shihunguilai\phpapi\Cache;

use Memcache;
use Exception;

class CacheMemcache
{
    private static $instance;
    private $handel;

    private function __construct()
    {
        $this->init();
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    private function init()
    {
        if (!extension_loaded('memcache')) {
            throw  new Exception('no memecache extension');
        }
        $this->handel = new Memcache();
        $this->handel->connect('127.0.0.1', '11211');
    }

    public static function getInstance()
    {
        if (!(self::$instance && self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($key, $value, $ttl = 0)
    {
        $this->handel->set($key, $value, $ttl);
    }

    /**
     * @param string $key
     *                    2016年10月4日-下午6:17:16
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function get($key)
    {
        return $this->handel->get($key);
    }

    /**
     * @param array $keys
     *                    2016年10月4日-下午6:18:43
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function mGet(array $keys)
    {
        return $this->handel->get($keys);
    }

    public function rm($key, $ttl = 0)
    {
        return $this->handel->delete($key, $ttl);
    }

    public function clear()
    {
        return $this->handel->flush();
    }

    public function __call($fun_name, $args)
    {
        if (method_exists($this->handel, $fun_name)) {
            return call_user_func_array(array($this->handel, $fun_name), $args);
        } else {
            throw new Exception('method not in '.$this->handel);
        }
    }
}
