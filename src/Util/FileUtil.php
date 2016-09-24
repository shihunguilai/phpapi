<?php

namespace shihunguilai\phpapi\Util;

class FileUtil
{
    public static function getCsvGenerator()
    {
    }
    /**
     * [exportCsv 导出csv文件].
     *
     * @param string              $file_name [description]
     * @param [Array | Generator] $list      [description]
     *
     * @return [null] [description]
     */
    public static function exportCsv($file_name, $list)
    {
        $filename = $file_name.'-'.date('YmdHis');
        if (php_sapi_name() == 'cli') {
            $ff = "./{$file_name}.csv";
            file_put_contents($ff, chr(0xEF).chr(0xBB).chr(0xBF));
            $str = self::convertArrayToCsvStr($list);
            file_put_contents($ff, $str, FILE_APPEND);
        } else {
            header('Cache-Control: public');
            header('Pragma: public');
            header('Content-Type:application/vnd.ms-excel');

            header("Content-Disposition:attachment;filename={$filename}.csv");
            echo chr(0xEF).chr(0xBB).chr(0xBF);

            echo self::convertArrayToCsvStr($list);
        }
    }

    public static function convertArrayToCsvStr(array $list)
    {
        $str = '';
        foreach ($list as $v) {
            $tmp = array_map(array(__CLASS__, 'dealExportString'), $v);
            $str .= implode(',', $tmp)."\n";
        }

        return $str;
    }

    public static function dealExportString($str)
    {
        if (!is_string($str)) {
            return $str;
        }
        $str = str_replace(PHP_EOL, ' ', $str);
        $str = str_replace("\n", '  ', $str);
        $str = str_replace("\r", '  ', $str);
        $str = str_replace(',', '，', $str);

        return $str;
    }
}
