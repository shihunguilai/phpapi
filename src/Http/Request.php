<?php

namespace shihunguilai\phpapi\Http;

class Request
{
    /**
     * [is_ajax description].
     *
     * @return bool [description]
     */
    public static function is_ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);
    }

    /**
     * [is_post description].
     *
     * @return bool [description]
     */
    public static function is_post()
    {
        return 'post' === strtolower(self::getRequestMethod());
    }

    /**
     * [is_get description].
     *
     * @return bool [description]
     */
    public static function is_get()
    {
        return 'get' === strtolower(self::getRequestMethod());
    }

    /**
     * [getRequestMethod description].
     *
     * @return [type] [description] GET POST De
     */
    public static function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function get()
    {
    }

    public function post()
    {
    }

    public static function getByFileGetContents($url, $param)
    {
        $context = array();
        $context = array(
                'http' => array(
                        'timeout' => 60,
                        'method' => 'GET',
            ),
        );
        $scc = stream_context_create($context);
        if (!empty($param)) {
            $url = $url.(strstr($url, '?') ? '&' : '?').http_build_query($param);
        }
// 		echo $url;exit;
        $res = file_get_contents($url, false, $scc);

        return $res;
    }

    public static function postByFileGetContents($url, $param = array())
    {
        $data = http_build_query($param);
        $len = strlen($data);
        $context = array();

        $header = 'Content-type: application/x-www-form-urlencoded'.PHP_EOL
                ."Content-length:{$len}".PHP_EOL
                .'Cookie: foo=bar'.PHP_EOL
        ;
        $context = array(
                'http' => array(
                        'timeout' => 60,
                        'method' => 'POST',
                        'content' => $data,
                        'header' => $header,
                ),
        );
        $scc = stream_context_create($context);
        $res = file_get_contents($url, false, $scc);

        return $res;
    }

    public static function getByCurl($url, $param = array())
    {
        $header = array(

        );
        if (!empty($param)) {
            $url = $url.(strstr($url, '?') ? '&' : '?').http_build_query($param);
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $info = curl_getinfo($ch);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public static function postByCurl($url, $param = array(), $file = array())
    {
        $header = array(

        );
        if (!empty($file)) {
            //有文件post
            foreach ($file as $k => $v) {
                $param[$k.''] = '@'.realpath($v);
            }
        } else {
            // 			$param =  http_build_query($param);
        }

// 		var_dump($param);exit;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

        $info = curl_getinfo($ch);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}
