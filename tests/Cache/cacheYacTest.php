<?php

namespace shihunguilai\phpapi\Cache;

class cacheYacTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!extension_loaded('yac')) {
            $this->markTestSkipped('no yac extension');
        }
    }

    public function tearDown()
    {
        CacheYac::getInstance()->clear();
    }

    public function testYacExt()
    {
        $this->assertTrue(extension_loaded('yac'));
    }

    public function testGetInstance()
    {
        $a = CacheYac::getInstance();
        $b = CacheYac::getInstance();
        $this->assertEquals($a, $b);
    }

    public function testSet()
    {
        $a = 'luck';
        $name = 'aa';
        CacheYac::getInstance()->set($name, $a);
        $this->assertEquals($a, CacheYac::getInstance()->get($name));
    }

    public function testmSet()
    {
        $da = [
        'dummy' => 'foo',
        'dummy2' => 'foo1',
      ];

        CacheYac::getInstance()->mSet($da);

        $this->assertEquals(CacheYac::getInstance()->get(array_keys($da)), $da);
    }

    public function testRm()
    {
        $name = 'a';
        $value = 'b';
        CacheYac::getInstance()->set($name, $value);
        $this->assertEquals(CacheYac::getInstance()->get($name), $value);
        CacheYac::getInstance()->rm($name);
        $this->assertFalse(CacheYac::getInstance()->get($name));
    }

    public function testDetail()
    {
        $this->assertNotNull(CacheYac::getInstance()->detail());
    }

    public function testClear()
    {
        $name = 'a';
        $value = 'b';
        CacheYac::getInstance()->set($name, $value);
        CacheYac::getInstance()->clear();
        $dd = CacheYac::getInstance()->detail();
        $this->assertEquals(0, $dd['slots_used']);
    }
}
