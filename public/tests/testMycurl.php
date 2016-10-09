<?php
require_once dirname(__DIR__).'/common.php';


//$url = 'http://***********/User/loginMobile/';
//$para = array(
//    'mobile'=>'********',
//    'code'=>'***********',
//);
//$cookies_file = __DIR__.'/cookies.txt';
//\shihunguilai\phpapi\Http\MyCurl::getCookies($url,$para,$cookies_file);

//$url = 'http://*************/Index/haveNewMsg/';
//$para = array();
//var_dump( \shihunguilai\phpapi\Http\MyCurl::requestWithCookies($url,$para,$cookies_file));



/*$url = 'http://phpapi.shihunguilai.com/tests/1b3b0071975c5a465195df8290f9e475.png';
$dir = '../../Upload/';
$rs=\shihunguilai\phpapi\Http\MyCurl::downLoadFile($url,$dir);
var_dump($rs);*/







/*if(filter_input(INPUT_GET,'act') == 'upload'){
    $upload = new \shihunguilai\phpapi\Util\Upload('../../Upload/');
    $res = $upload->doUPload();
    var_dump($res) ;exit;
}

$files = array(
    '../../Upload/7f511ec6f6be5adfe74618fe3a1a4fb9.png',
    '../../Upload/1b3b0071975c5a465195df8290f9e475.png',

);
$url = 'http://'.$_SERVER['SERVER_NAME'].'/tests/testMycurl.php?act=upload';
$rs = \shihunguilai\phpapi\Http\MyCurl::postFile($url,$files);
var_dump($rs);*/