<?php

namespace shihunguilai\phpapi\Cache;

use PHPUnit_Framework_TestCase;

class CacheMemcacheTest extends PHPUnit_Framework_TestCase
{
    private $instance;

    public function setUp()
    {
        parent::setUp();
        if (!extension_loaded('memcache')) {
            $this->markTestSkipped('memcache extenstons not installed');
        }
        $this->instance = CacheMemcache::getInstance();
    }

    public function testsetAndget()
    {
        $k = 'name';
        $n = 'php';
        $this->instance->set($k, $n);
        $this->assertEquals($n, $this->instance->get($k));

        $k1 = 'n';
        $n1 = 'p1';
        $this->instance->set($k1, $n1);

        $this->assertEquals(array($k => $n, $k1 => $n1),
            $this->instance->mGet(array($k, $k1)));
    }

    public function testrm()
    {
        $k = 'name';
        $n = 'php';
        $this->instance->set($k, $n);
        $this->instance->rm($k);
        $this->assertFalse($this->instance->get($k));
    }

    public function testclear()
    {
        $this->assertTrue($this->instance->clear());
    }

    public function testgetVersion()
    {
        //var_dump($this->instance->getVersion());
    }

    public function testaddServer()
    {
        //         var_dump($this->instance->addServer('localhost',11212));
    }

    public function testgetExtendedStats()
    {
        //         print_r($this->instance->getExtendedStats());
    }

    public function testgetServerStatus()
    {
        //         var_dump($this->instance->getServerStatus('localhost',11212));
    }
}
