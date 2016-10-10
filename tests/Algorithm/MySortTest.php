<?php

namespace shihunguilai\phpapi\Algorithm;

class MySortTest extends \PHPUnit_Framework_TestCase
{
    public function testbubble_sort()
    {
        $a = array(3, 4, 5, 7, 3, 9, 87, 245);
        $this->assertSame(array(245, 87, 9, 7, 5, 4, 3, 3), MySort::bubble_sort($a, 'desc'));
        $this->assertSame(array(3, 3, 4, 5, 7, 9, 87, 245), MySort::bubble_sort($a, 'asc'));
    }
}
