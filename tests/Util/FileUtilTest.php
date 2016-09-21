<?php

namespace shihunguilai\phpapi\Util;

class FileUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testexportCsv()
    {
        $arr = [
      ['title', 'score', 'name'],
      ['a', 'b', 'c'],
      [1, 2, 3],
    ];
        $file = './tmpcsv.csv';
        if (file_exists($file)) {
            unlink($file);
        }
        FileUtil::exportCsv('tmpcsv', $arr);

        $r_list = array();
        foreach (new CsvIterator($file) as $k => $v) {
            $r_list[] = $v;
        }
        unlink($file);
        $this->assertEquals($arr, $r_list);
    }
}
