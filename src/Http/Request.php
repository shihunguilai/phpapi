<?php

namespace shihunguilai\phpapi\Http;

class Request
{
    public static function is_weibo()
    {
        return false !== strpos(self::getUserAgent(), 'Weibo');
    }

    public static function is_winxin()
    {
        return false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger');
    }

    public static function is_mobile()
    {
        if (
            isset($_SERVER['HTTP_VIA'])
            && stristr($_SERVER['HTTP_VIA'], 'wap')
            ) {
            return true;
        }

        $userAgent = self::getUserAgent();
        $pattern = '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i';
        if (preg_match($pattern, $userAgent)) {
            return true;
        }

        if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false)) {
            return true;
        }

        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_PROFILE'])) {
            return true;
        }
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
                        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
                        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
                        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
                        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
                        'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
                        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
                        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
                        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
                        'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-',
                    );

        if (in_array($mobile_ua, $mobile_agents)) {
            return true;
        }
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) {
            return true;
        }
//         if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) {
//             return false;
//         }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) {
            return true;
        }

        return false;
    }
    public static function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : null;
    }
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