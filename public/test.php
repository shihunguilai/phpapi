<?php

require_once __DIR__.'/common.php';

echo session_id().'-'.session_name();

var_dump( $_SESSION['aaaa']);