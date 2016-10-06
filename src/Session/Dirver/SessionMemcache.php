<?php

namespace shihunguilai\phpapi\Session\Dirver;

use shihunguilai\phpapi\Session\AbstrSession;

class SessionMemcache extends AbstrSession
{
    private static $handler = null;

    private static $prefix = '';

    private static $options = array(
        'host' => '127.0.0.1',
        'port' => '11211',
        'maxlifetime' => null,
    );

    public function __construct($options = array())
    {
        if (!extension_loaded('memcache')) {
            throw new \Exception('no memcache extensions');
        }

        if (!(isset($options['maxlifetime']) && is_int($options['maxlifetime']) && $options['maxlifetime'] > 0)) {
            $options['maxlifetime'] = ini_get('session.gc_maxlifetime');
        }
        self::$options = array_merge(self::$options, $options);
    }

    public function open($save_path, $session_name)
    {
        if (self::$handler instanceof \Memcache) {
            return true;
        }
        $handler = new \Memcache();
        $handler->connect(self::$options['host'], self::$options['port']);
        if (!$handler) {
            throw new \Exception('connect Memcache fails');
        }
        self::$handler = $handler;
        self::$prefix = 'phpmemcache_session:';
        $this->gc(self::$options['maxlifetime']);

        return true;
    }

    public function getRealKey($session_id)
    {
        return self::$prefix.$session_id;
    }

    public function read($session_id)
    {
        return self::$handler->get($this->getRealKey($session_id));
    }

    public function write($session_id, $session_data)
    {
        self::$handler->set(
            $this->getRealKey($session_id),
            $session_data,
            self::$options['maxlifetime']
            );

        return true;
    }

    public function close()
    {
        if (self::$handler) {
            self::$handler->close();
        }

        return true;
    }

    public function destroy($session_id)
    {
        $r = self::$handler->delete($this->getRealKey($session_id));

        return $r >= 1 ? true : false;
    }

    public function gc($maxlifetime)
    {
        return true;
    }
}
