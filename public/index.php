<?php
use shihunguilai\phpapi\Http\Request;
require_once '../vendor/autoload.php';

echo "<h1>welcome cliff zhang</h1>";

$lf = "<br/>";

echo Request::getUserAgent().$lf;
echo Request::getRequestMethod().$lf;

var_dump(Request::is_android());
var_dump( Request::is_Apple());
//exit;


var_dump(Request::is_ajax());

var_dump(Request::is_get());
var_dump(Request::is_post());



phpinfo();