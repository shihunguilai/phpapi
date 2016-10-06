<?php

namespace shihunguilai\phpapi\Session\Dirver;

use shihunguilai\phpapi\Session\AbstrSession;

class SessionFilesIni extends AbstrSession
{
    public function __construct($options = array())
    {
    }

    public function begin()
    {
        ini_set('session.save_handler', 'files');
//        ini_set('session.save_path',__DIR__);
       ini_set('session.cookie_domain', '.shihunguilai.com');
        session_start();
    }
}
