<?php

namespace shihunguilai\phpapi\Algorithm;

class MySort
{
    public static function merge($a, $b)
    {
        $c = array();
        while (!empty($a) && !empty($b)) {
            $c[] = $a[0] < $b[0] ? array_shift($a) : array_shift($b);
        }

        return array_merge($c, $a, $b);
    }

    /**
     *  归并排序.
     *
     * @param array $arr
     *                   2016年10月11日-下午11:07:56
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function merge_sort($arr = array())
    {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        }
        $mid = intval($len / 2);
        $left_arr = self::merge_sort(array_slice($arr, 0, $mid));
        $right_arr = self::merge_sort(array_slice($arr, $mid));
        $arr = self::merge($left_arr, $right_arr);

        return $arr;
    }

    /**
     * 插入排序.
     *
     * @param array $arr
     *
     * @return unknown
     *                 2016年10月11日-下午11:08:25
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function insert_sort($arr = array())
    {
        $len = count($arr);
        for ($i = 1; $i < $len; ++$i) {
            $tp = $arr[$i];
            for ($j = $i - 1; $j >= 0; --$j) {
                if ($arr[$j] > $tp) {
                    $arr[$j + 1] = $arr[$j];
                    $arr[$j] = $tp;
                }
            }
        }

        return $arr;
    }

    public static function swap(&$a, &$b)
    {
        $a = $a ^ $b;
        $b = $a ^ $b;
        $a = $a ^ $b;
    }

    /**
     * 选择排序.
     *
     * @param array $arr
     *                   2016年10月11日-下午11:08:51
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function select_sort($arr = array())
    {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        }
        for ($i = 0; $i < $len; ++$i) {
            $k = $i;
            for ($j = $i + 1; $j < $len; ++$j) {
                if ($arr[$j] < $arr[$i]) {
                    $k = $j;
                }
            }
            if ($k != $i) {
                self::swap($arr[$i], $arr[$k]);
            }
        }

        return $arr;
    }

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
