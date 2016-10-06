<?php

// phpinfo();exit;

use shihunguilai\phpapi\Http\Request;
require_once __DIR__.'/common.php';

echo "<h1>welcome cliff zhang</h1>";

$lf = "<br/>";

echo session_id().'-'.session_name();
// session_destroy();exit;
$_SESSION['aaaa'] = array('ll'=>'fjkdfjkd');

echo '<hr>';

echo ini_get('session.save_path').'-'
.ini_get('session.cookie_lifetime').'-'.ini_get('session.gc_maxlifetime').'-'.ini_get('session.use_trans_sid');

exit;




echo Request::getUserAgent().$lf;
echo Request::getRequestMethod().$lf;

var_dump(Request::is_android());
var_dump( Request::is_Apple());
//exit;


var_dump(Request::is_ajax());

var_dump(Request::is_get());
var_dump(Request::is_post());



phpinfo();