<?php

namespace shihunguilai\phpapi\Util;

/**
 * Created by PhpStorm.
 * User: cliff zhang
 * Date: 2016/10/8
 * Time: 11:27.
 */
class ApiUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testurl_base64_encode()
    {
        $a = 1;
        $s = ApiUtil::url_base64_encode($a);
        $this->assertEquals($a, ApiUtil::url_base64_decode($s));
    }
}
