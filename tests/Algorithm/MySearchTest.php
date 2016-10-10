<?php

namespace shihunguilai\phpapi\Algorithm;

class MySearchTest extends \PHPUnit_Framework_TestCase
{
    public function testbinary_search()
    {
        $arr = range(0, 100);
        $find = 77;
        $this->assertEquals(77, MySearch::binary_search($arr, 0, count($arr) - 1, $find));
        unset($arr);
    }

    public function testbinary_recurisive_search()
    {
        $arr = range(0, 10000);
        $find = 768;
        $this->assertEquals(768, MySearch::binary_recurisive_search($arr, 0, count($arr) - 1, $find));
        unset($arr);
    }
}
