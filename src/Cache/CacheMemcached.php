<?php

namespace shihunguilai\phpapi\Cache;

class CacheMemcached
{
    private static $instance;
    private $handler;

    private function __construct()
    {
        $this->init();
    }

    private function init()
    {
        if (!extension_loaded('memcached')) {
            throw new \Exception('no memcached extension');

            return false;
        }
        $this->handler = new \Memcached();
        $this->handler->addServer('127.0.0.1', 11211);
    }
    private function __clone()
    {
    }
    private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (!(self::$instance && self::$instance instanceof  self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param number $ttl
     *                      2016年10月4日-下午10:05:53
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function set($key, $value, $ttl = 0)
    {
        return $this->handler->set($key, $value, $ttl);
    }

    public function mSet(array $kvs, $ttl = 0)
    {
        return $this->handler->setMulti($kvs, $ttl);
    }

    public function mGet(array $arr)
    {
        return $this->handler->getMulti($arr);
    }

    /**
     * @param string $key
     *                    2016年10月4日-下午10:05:38
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function get($key)
    {
        return $this->handler->get($key);
    }

    public function clear($ttl = 0)
    {
        return $this->handler->flush($ttl);
    }
    /**
     * @param string  $key
     * @param unknown $ttl
     *                     2016年10月4日-下午10:08:26
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function rm($key, $ttl = 0)
    {
        return $this->handler->delete($key, $ttl);
    }

    public function __call($fun_name, $args)
    {
        if (method_exists($this->handler, $fun_name)) {
            return call_user_func_array(array($this->handler, $fun_name), $args);
        } else {
            throw new \Exception($fun_name.' not in '.$this->handler);
        }
    }
}
