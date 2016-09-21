<?php

namespace shihunguilai\phpapi\Util;

class FileUtil
{
    public static function getCsvGenerator($file)
    {
    }
    /**
     * [exportCsv 导出csv文件].
     *
     * @param [type]              $file_name [description]
     * @param [Array | Generator] $list      [description]
     *
     * @return [type] [description]
     */
    public static function exportCsv($file_name, $list)
    {
        $filename = $file_name.'-'.date('YmdHis');
        if (php_sapi_name() == 'cli') {
            $ff = "./{$file_name}.csv";
            file_put_contents($ff, chr(0xEF).chr(0xBB).chr(0xBF));
            $str = '';
            foreach ($list as $v) {
                $tmp = array();
                $tmp = array_map(array(__CLASS__, 'dealExportString'), $v);
                $str .= implode(',', $tmp)."\n";
            }
            file_put_contents($ff, $str, FILE_APPEND);
        } else {
            header('Cache-Control: public');
            header('Pragma: public');
            header('Content-Type:application/vnd.ms-excel');

            header("Content-Disposition:attachment;filename={$filename}.csv");
            echo chr(0xEF).chr(0xBB).chr(0xBF);

            $str = '';
            foreach ($list as $v) {
                $tmp = array();
                $tmp = array_map(array(__CLASS__, 'dealExportString'), $v);
                $str .= implode(',', $tmp)."\n";
            }
            echo $str;
        }
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
