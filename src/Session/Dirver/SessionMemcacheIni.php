<?php

namespace shihunguilai\phpapi\Session\Dirver;

use shihunguilai\phpapi\Session\AbstrSession;

class SessionMemcacheIni extends AbstrSession
{
    public function __construct($option = array())
    {
    }

    public function begin()
    {
        ini_set('session.save_handler', 'memcache');
        ini_set('session.save_path', 'tcp://127.0.0.1:11211?persistent=1&weight=1&timeout=1&retry_interval=15');
        ini_set('session.cookie_domain', '.shihunguilai.com');
        session_start();
    }
}
