<?php

namespace shihunguilai\phpapi\Cache;

class CacheMemcahedTest extends \PHPUnit_Framework_TestCase
{
    private $instance;

    public function setUp()
    {
        parent::setUp();
        if (!extension_loaded('memcached')) {
            $this->markTestSkipped('no memcached extension');

            return false;
        }
        $this->instance = CacheMemcached::getInstance();
    }

    public function testsetAndget()
    {
        $k = 'n';
        $v = '1';
        $this->instance->set($k, $v);
        $this->assertEquals($v, $this->instance->get($k));

//         $this->instance->set($k, $v,3);
//         sleep(3);
//         $this->assertFalse($this->instance->get($k));
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

    public function testgetStats()
    {
        //         print_r($this->instance->getStats());
    }

    public function testgetVersion()
    {
        //         var_dump($this->instance->getVersion());
    }

    public function testgetServerList()
    {
        //         print_r($this->instance->getServerList());
    }
}
