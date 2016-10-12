<?php

namespace shihunguilai\phpapi\Algorithm;

class MySort
{
    public static function bubble_sort($arr = array(), $type = 'asc')
    {
        if (!is_array($arr)) {
            return false;
        }
        if (empty($arr)) {
            return array();
        }
        $len = count($arr);
        for ($i = 0; $i < $len; ++$i) {
            $is_sortable = true;
            for ($j = 0; $j < $len - $i - 1; ++$j) {
                if (
                ($type == 'asc' && $arr[$j] > $arr[$j + 1])
                ||
                ($type == 'desc' && $arr[$j] < $arr[$j + 1])
                ) {
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $tmp;
                    $is_sortable = false;
                }
            }
            if ($is_sortable) {
                break;
            }
        }
        return $arr;
    }
}
