<?php

namespace shihunguilai\phpapi\Cache;

use shihunguilai\phpapi\Util\ApiUtil;
use Yac;

/**
 * Created by PhpStorm.
 * User: clff zhang.
 */
class CacheYac
{
    private $have_extension = false;
    private $cache_pre = '';
    private $m = null;

    private static $instance = null;

    private function __construct()
    {
        $this->init();
    }

    private function __clone()
    {
    }

    private function init()
    {
        if (extension_loaded('yac')) {
            $this->have_extension = true;
            $this->m = new Yac($this->cache_pre);
        } else {
            throw new \Exception('yac extension not installed');
        }
    }

    public static function getInstance()
    {
        if (!(self::$instance && self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @param int    $ttl
     *
     * @return bool
     */
    public function set($name, $value, $ttl = 0)
    {
        $value = ApiUtil::myserialize($value);
        if (is_int($ttl) && $ttl) {
            return $this->m->set($name, $value, $ttl);
        }

        return $this->m->set($name, $value);
    }

    /**
     * @param array $kvs
     * @param int   $ttl
     *
     * @return mixed
     */
    public function mSet(array $kvs, $ttl = 0)
    {
        $kvs = array_map(function ($v) {
            return ApiUtil::myserialize($v);
        }, $kvs);
        if (is_int($ttl) && $ttl) {
            return  $this->m->set($kvs, $ttl);
        }

        return $this->m->set($kvs);
    }

    /**
     * @param string | array $name
     *
     * @return mixed
     */
    public function get($name)
    {
        $tp = $this->m->get($name);
        if (!$tp || empty($tp)) {
            return $tp;
        }
        if (is_string($name)) {
            return ApiUtil::myunserialize($tp);
        } elseif (is_array($name)) {
            $tp = array_map(function ($v) {
                return ApiUtil::myunserialize($v);
            }, $tp);

            return $tp;
        }
    }

    /**
     * @param string | array $name
     * @param int            $delay
     *
     * @return mixed
     */
    public function rm($name, $delay = 0)
    {
        return $this->m->delete($name, $delay);
    }

    /**
     * @return mixed
     */
    public function clear()
    {
        return $this->m->flush();
    }

    public function detail()
    {
        return $this->m->info();
    }
}
