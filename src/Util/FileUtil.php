<?php

namespace shihunguilai\phpapi\Util;

class FileUtil
{
    public static function exportExcel($file_name, $list)
    {
        $filename = $file_name.'-'.date('YmdHis');
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
        exit;
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
