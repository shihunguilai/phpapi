<?php

namespace shihunguilai\phpapi\Algorithm;

class MySort
{
    /**
     * 快速排序.
     *
     * @param array  $arr
     * @param string $type
     *                     2016年10月10日-下午9:21:06
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function quick_sort($arr = array(), $type = 'asc')
    {
        if (!is_array($arr)) {
            return false;
        }
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        }
        $stand = $arr[0];
        $left_arr = $right_arr = array();
        for ($i = 1; $i < $len; ++$i) {
            if (
                ($type == 'asc' && $arr[$i] <= $stand)
                ||
                ($type == 'desc' && $arr[$i] >= $stand)
               ) {
                $left_arr[] = $arr[$i];
            } else {
                $right_arr[] = $arr[$i];
            }
        }
        $left_arr = self::quick_sort($left_arr, $type);
        $right_arr = self::quick_sort($right_arr, $type);

        return  array_merge($left_arr, array($stand), $right_arr);
    }

    /**
     * 优化的冒泡排序.
     *
     * @param array  $arr
     * @param string $type
     *                     2016年10月10日-下午9:03:07
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function bubble_sort($arr = array(), $type = 'asc')
    {
        if (!is_array($arr)) {
            return false;
        }
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        }
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
