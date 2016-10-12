<?php

namespace shihunguilai\phpapi\Algorithm;

class MySearch
{
    /**
     * 普通的二分查找 查找一个值在数组中的位置.
     *
     * @param array $arr    操作的数组，前提是按顺序排列
     * @param int   $low    查找的起始位置，默认从数组的第一个数找起
     * @param int   $high   查找的结束位置
     * @param mixed $target 查找的值
     *                      2016年10月10日-下午10:33:16
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function binary_search(&$arr, $low, $high, $target)
    {
        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            if ($arr[$mid] == $target) {
                return $mid;
            } elseif ($arr[$mid] < $target) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }

        return -1;
    }

    /**
     * 普通的二分查找 查找一个值在数组中的位置.
     *
     * @param array $arr    操作的数组，前提是按顺序排列
     * @param int   $low    查找的起始位置，默认从数组的第一个数找起
     * @param int   $high   查找的结束位置
     * @param mixed $target 查找的值
     *                      2016年10月10日-下午10:33:16
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function binary_recurisive_search($arr, $low, $high, $target)
    {
        if ($low > $high) {
            return -1;
        } else {
            $mid = floor(($high + $low) / 2);
            if ($arr[$mid] == $target) {
                return $mid;
            } elseif ($arr[$mid] < $target) {
                return self::binary_recurisive_search($arr, $mid + 1, $high, $target);
            } else {
                return self::binary_recurisive_search($arr, $low, $mid - 1, $target);
            }
        }
    }
}
