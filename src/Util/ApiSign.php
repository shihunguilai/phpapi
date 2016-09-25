<?php

namespace shihunguilai\phpapi\Util;

/**
 * api 接口开发过程中 传输数据的 签名 和 验签.
 *
 * 2016年9月24日-下午5:11:30
 *
 * @author cliff zhang.<1058462838@qq.com>
 */
class ApiSign
{
    private static $sign_salt = 'your sign salt';

    /**
     * check sign.
     *
     * @return bool
     *              2016年9月24日-下午4:48:02
     *              cliff zhang.<1058462838@qq.com>
     */
    final public static function checkSign()
    {
        $get = filter_input_array(INPUT_GET);
        if (filter_input_array(INPUT_POST)) {
            $get = array_merge($get, filter_input_array(INPUT_POST));
        }

        $str = '';
        krsort($get);
        foreach ($get as $k => $v) {
            if ($k != 'tk') {
                $str .= $v;
            }
        }
        $tk = $get['tk'];
        if ($tk != md5(md5($str.self::$sign_salt))) {
            return false;
        }

        return true;
    }

    /**
     * create sign.
     *
     * @param array $arr
     *
     * @return string
     *                2016年9月24日-下午4:51:15
     *                cliff zhang.<1058462838@qq.com>
     */
    final public static function createSign($arr = array())
    {
        if (empty($arr)) {
            return '';
        }
        krsort($arr);
        $str = '';
        foreach ($arr as $v) {
            $str .= $v;
        }
        $tk = md5(md5($str.self::$sign_salt));

        return $tk;
    }
}
