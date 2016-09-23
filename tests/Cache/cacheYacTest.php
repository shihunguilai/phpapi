<?php

namespace shihunguilai\phpapi\Cache;

class CacheYacTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!extension_loaded('yac')) {
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

    public function testGetInstance()
    {
        $a = cacheYac::getInstance();
        $b = cacheYac::getInstance();
        $this->assertEquals($a, $b);
    }

    public function testSet()
    {
        $a = 'luck';
        $name = 'aa';
        cacheYac::getInstance()->set($name, $a);
        $this->assertEquals($a, cacheYac::getInstance()->get($name));
    }

    public function testmSet()
    {
        $da = [
        'dummy' => 'foo',
        'dummy2' => 'foo1',
      ];

        cacheYac::getInstance()->mSet($da);

        $this->assertEquals(cacheYac::getInstance()->get(array_keys($da)), $da);
    }

    public function testRm()
    {
        $name = 'a';
        $value = 'b';
        cacheYac::getInstance()->set($name, $value);
        $this->assertEquals(cacheYac::getInstance()->get($name), $value);
        cacheYac::getInstance()->rm($name);
        $this->assertFalse(cacheYac::getInstance()->get($name));
    }

    public function testDetail()
    {
        $this->assertNotNull(cacheYac::getInstance()->detail());
    }

    public function testClear()
    {
        $name = 'a';
        $value = 'b';
        cacheYac::getInstance()->set($name, $value);
        cacheYac::getInstance()->clear();
        $dd = cacheYac::getInstance()->detail();
        $this->assertEquals(0, $dd['slots_used']);
    }
}
