<?php

namespace shihunguilai\phpapi\Util;

class ApiUtil
{
    /**
   * [myserialize description].
   *
   * @param  [mixed] $data [description]
   *
   * @return [string]       [description]
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
