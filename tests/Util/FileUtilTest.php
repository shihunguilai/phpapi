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
        FileUtil::exportCsv('tmpcsv', $arr);
    }
}
