<?php

namespace shihunguilai\phpapi\Http;

class MyCurl
{
    /**
     * https请求 除非用了非法或者自制的证书，这大多数出现在开发环境中，
     * 你才将这两行设置为false以避开ssl证书检查，否者不需要这么做，
     * 这么做是不安全的做法。
     *
     * @param resource $ch
     * @param string   $url
     * @param bool     $is_dev
     *                         User:cliff zhang
     */
    private static function dealHttps($ch, $url, $is_dev = false)
    {
        $is_https = strpos($url, 'https://') !== false;
        if ($is_https && !$is_dev) {
            //php内部 curl 默认处理方式
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
    }

    public static function get($url, $para)
    {
        if (is_array($para) && !empty($para)) {
            $url .= strstr($url, '?') ? '&' : '?'.http_build_query($para);
        }
        $ch = curl_init();
        self::dealHttps($ch, $url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    /**
     * @param string $url
     * @param array  $para
     * @param array  $header
     *
     * @return array
     *               User:cliff zhang
     */
    public static function postArray($url, $para, $header)
    {
        $ch = curl_init();
        self::dealHttps($ch, $url);
        curl_setopt_array($ch,
            array(
                CURLOPT_URL => $url,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => http_build_query($para),
                CURLOPT_RETURNTRANSFER => 1,
            ));
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $ret = array();
        $ret['output'] = curl_exec($ch);
        $ret['info'] = curl_getinfo($ch);
        curl_close($ch);

        return $ret;
    }

    /**
     * @param string $url
     * @param string $para json str
     *
     * @return mixed
     *               User:cliff zhang
     */
    public static function postJson($url, $para)
    {
        $header_arr = array(
            'Content-Type：application/json',
            'Content-Length：'.strlen($para),
        );
        $ch = curl_init();
        self::dealHttps($ch, $url);
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_HTTPHEADER => $header_arr,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $para,

        ));
        $ret = array();
        $ret['output'] = curl_exec($ch);
        $ret['info'] = curl_getinfo($ch);
        curl_close($ch);

        return $ret;
    }

    private static function getcurlfileObject($file)
    {
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            return new \CURLFile(realpath($file));
        }

        return '@'.realpath($file);
    }

    public static function postFile($url, $files)
    {
        $data = array();
        foreach ($files as $v) {
            $data[md5($v)] = self::getcurlfileObject($v);
        }
        $ch = curl_init();
        self::dealHttps($ch, $url);
        curl_setopt_array($ch,
            array(
                CURLOPT_URL => $url,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_RETURNTRANSFER => 1,
            ));
//        if (!empty($header)) {
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        }
        $ret = array();
        $ret['output'] = curl_exec($ch);
        $ret['info'] = curl_getinfo($ch);
        curl_close($ch);

        return $ret;
    }

    public static function downLoadFile($url, $dir)
    {
        $ch = curl_init();
        self::dealHttps($ch, $url);
        $file_p = realpath($dir).'/'.md5(md5(microtime(true)).rand(1, 1000)).'.'.pathinfo($url, PATHINFO_EXTENSION);
        $fp = fopen($file_p, 'w');
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FILE => $fp,
        ));
        curl_exec($ch);
        $ret = array();
        $ret['output'] = $file_p;
        $ret['info'] = curl_getinfo($ch);
        fclose($fp);
        curl_close($ch);

        return $ret;
    }

    public static function getCookies($url, $para, $cookies_file)
    {
        $ch = curl_init();
        self::dealHttps($ch, $url);
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_COOKIEJAR => $cookies_file,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($para),
        ));
        curl_exec($ch);
        curl_close($ch);
    }

    public static function requestWithCookies($url, $para, $cookies_file, $method = 'get')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ('get' == strtolower($method) && !empty($para)) {
            $url .= strstr($url, '?') ? '&' : '?'.http_build_query($para);
        }
        self::dealHttps($ch, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        if ('post' == strtolower($method) && !empty($para)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($para));
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies_file);

        $ret = array();
        $ret['output'] = curl_exec($ch);
        $ret['info'] = curl_getinfo($ch);
        curl_close($ch);

        return $ret;
    }
}
