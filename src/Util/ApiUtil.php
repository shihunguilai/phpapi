<?php

namespace shihunguilai\phpapi\Util;

class ApiUtil
{
    /**
     * @param mixed $data
     *
     * @return string
     *                User:cliff zhang
     */
    public static function url_base64_encode($data)
    {
        return rtrim(str_replace(array('+', '/'), array('-', '_'), base64_encode($data)), '=');
    }

    /**
     * @param string $data
     *
     * @return mixed
     *               User:cliff zhang
     */
    public static function url_base64_decode($data)
    {
        $ret = str_replace(array('-', '_'), array('+', '/'), $data);
        $m = strlen($ret) % 4;
        if ($m) {
            $ret .= substr('====', $m);
        }

        return base64_decode($ret);
    }

    /**
     * @param mixed $data
     *
     * @return string
     *                2016年9月25日-上午1:08:25
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public static function myserialize($data)
    {
        return base64_encode(gzcompress(serialize($data)));
    }

    public static function myunserialize($data)
    {
        return unserialize(gzuncompress(base64_decode($data)));
    }

    final public static function myExplode($str, $delimiter)
    {
        $ss = trim($str);
        $ss = trim($ss, $delimiter);
        if (empty($ss)) {
            return array();
        }
        $arr = explode($delimiter, $str);

        return empty($arr) ? array() : $arr;
    }

    final public static function formatTime($time)
    {
        if (!is_numeric($time)) {
            $time = (string) strtotime($time);
        }

        $now = time();
        if ($now < ($time + 60)) {
            $s = $now - $time;
            if ($s == 0) {
                $s = 1;
            }
            $strtime = $s.'秒前';
        } elseif ($now >= ($time + 60) && $now < ($time + 3600)) {
            $strtime = ((int) (($now - $time) / 60)).'分前';
        } elseif ($now >= ($time + 3600) && $now < ($time + 86400)) {
            $strtime = ((int) (($now - $time) / 3600)).'小时前';
        } elseif ($now >= ($time + 86400) && $now < ($time + 604800)) {
            $strtime = ((int) (($now - $time) / 86400)).'天前';
        } else {
            if (empty($time)) {
                $strtime = '15天前';
            } elseif (date('Y', $time) == date('Y')) {
                $strtime = date('m-d', $time);
            } else {
                $strtime = date('Y-m-d', $time);
            }
        }

        return $strtime;
    }
}
