<?php
namespace shihunguilai\phpapi;

use shihunguilai\phpapi\Cache\cacheYac;
/**
 *
 */
class cacheYacTest extends \PHPUnit_Framework_TestCase
{

    public function testYacExt()
    {
      $this->assertTrue(!extension_loaded('yac'));
    }


    // function testGetInstance()
    // {
    //     $a = cacheYac::getInstance();
    //     $b = cacheYac::getInstance();
    //     $this->assertEquals($a,$b);
    // }
    //
    // function testSet()
    // {
    //     $a = 'luck';
    //     $name = 'aa';
    //     cacheYac::getInstance()->set($name,$a);
    //     $this->assertEquals($a,cacheYac::getInstance()->get($name));
    // }



}
