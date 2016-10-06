<?php

namespace shihunguilai\phpapi\Session\Dirver;

use shihunguilai\phpapi\Session\AbstrSession;

class SessionRedisIni extends AbstrSession
{
    public function __construct($option = array())
    {
    }

    public function begin()
    {
        ini_set('session.save_handler', 'redis');
        ini_set('session.save_path', 'tcp://127.0.0.1:6379');
        ini_set('session.cookie_domain', '.shihunguilai.com');
        session_start();
    }
}
