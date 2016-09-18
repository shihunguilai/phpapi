<?php
namespace Cliff\Cache;
use cliff\Util\ApiUtil;

/**
 * Created by PhpStorm.
 * User: clff zhang
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

    private function init()
    {
        if(extension_loaded('yac')){
            $this->have_extension = true;
            $this->m = new \Yac($this->cache_pre);
        }
    }

    public static function getInstance()
    {
        if(!(self::$instance && self::$instance instanceof self)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function set($name,$value,$ttl = 0)
    {
        if(!$this->have_extension){return false;}
        $value = ApiUtil::myserialize($value);
        if(is_int($ttl) && $ttl){
            return $this->m->set($name,$value,$ttl);
        }
        return $this->m->set($name,$value);
    }


    /**
     * @param array $kvs
     * @param int $ttl
     * @return mixed
     */
    public function mSet(array $kvs,$ttl = 0)
    {
        if(!$this->have_extension){return false;}
        array_walk($kvs,function(&$val){
            $val = ApiUtil::myserialize($val);
        });
        if(is_int($ttl) && $ttl){
            return  $this->m->set($kvs,$ttl);
        }
        return $this->m->set($kvs);
    }


    /**
     * @param string | array $name
     * @return mixed
     */
    public function get($name)
    {
        if(!$this->have_extension){return null;}
        $tp = $this->m->get($name);
        if(is_string($name)){
            return ApiUtil::myunserialize($tp);
        }elseif (is_array($name)) {
            array_walk($tp,function(&$val){
                $val = ApiUtil::myunserialize($val);
            });
            return $tp;
        }
    }

    /**
     * @param  string | array $name
     * @param int $delay
     * @return mixed
     */
    public function rm($name,$delay = 0)
    {
        if(!$this->have_extension){return false;}
        return $this->m->delete($name,$delay);
    }


    /**
     * @return mixed
     */
    public function clear()
    {
        if(!$this->have_extension){return false;}
        return $this->m->flush();
    }


    public function detail()
    {
        if(!$this->have_extension){return null;}
        return $this->m->info();
    }



}
