<?php

namespace shihunguilai\phpapi\Session;

class MySession
{
    private static $handler = null;
    private static $session_type = null;

    /**
     * @param string $type    (memcacheini,redisini,redis,memcache,db,files)
     * @param array  $options
     *
     * @throws \Exception
     *                    2016年10月6日-下午6:43:54
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function start($type, $options = array())
    {
        if (!empty(self::$handler)) {
            return $this;
        }
        $class = 'shihunguilai\\phpapi\\Session\\Dirver\\Session'.ucwords($type);
        if (!class_exists($class)) {
            throw  new \Exception('no dirver session '.$type);

            return false;
        }
        self::$handler = new $class($options);
//         var_dump(self::$handler);
        self::$session_type = $type;
        self::begin();
    }

    public static function begin()
    {
        $rs = call_user_func_array(array(self::$handler, 'begin'), array());
    }
}
