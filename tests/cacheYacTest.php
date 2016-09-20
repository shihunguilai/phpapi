<?php
namespace shihunguilai\phpapi;

use shihunguilai\phpapi\Cache\cacheYac;
/**
 *
 */
class cacheYacTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
      if(!extension_loaded('yac')){
        $this->markTestSkipped('no yac extension');
      }
    }


    public function tearDown()
    {
      cacheYac::getInstance()->clear();
    }

    public function testYacExt()
    {
      $this->assertTrue(extension_loaded('yac'));
    }


    function testGetInstance()
    {
        $a = cacheYac::getInstance();
        $b = cacheYac::getInstance();
        $this->assertEquals($a,$b);
    }

    function testSet()
    {
        $a = 'luck';
        $name = 'aa';
        cacheYac::getInstance()->set($name,$a);
        $this->assertEquals($a,cacheYac::getInstance()->get($name));
    }

    public function testmSet()
    {
      $da = array(
        "dummy" => "foo",
        "dummy2" => "foo1",
      );

      cacheYac::getInstance()->mSet($da);

      $this->assertEquals(cacheYac::getInstance()->get(array_keys($da)),$da);

    }

    public function testRm()
    {
        $name = 'a';
        $value = 'b';
        cacheYac::getInstance()->set($name,$value);
        $this->assertEquals(cacheYac::getInstance()->get($name),$value);
        cacheYac::getInstance()->rm($name);
        $this->assertFalse(cacheYac::getInstance()->get($name));
    }

    public function testDetail()
    {
        print_r(cacheYac::getInstance()->detail());
    }

    function testClear()
    {
        $name = 'a';
        $value = 'b';
        cacheYac::getInstance()->set($name,$value);
        cacheYac::getInstance()->clear();
        $dd = cacheYac::getInstance()->detail();
        $this->assertEquals(0,$dd['slots_used']);
    }





}
