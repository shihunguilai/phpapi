<?php

namespace shihunguilai\phpapi\Util;

/**
 * csv iterator php
 * user:cliff zhang.
 */
class CsvIterator implements \Iterator
{
    private $fd;
    private $line_num = 0;
    private $line = '';

    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new \Exception($filename.'not exists');
        }
        $this->fd = fopen($filename, 'r');
    }

    public function __destruct()
    {
        if ($this->fd) {
            fclose($this->fd);
        }
    }

    public function current()
    {
        $str = str_replace(chr(0xEF).chr(0xBB).chr(0xBF), '', trim($this->line));

        return explode(',', $str);
    }

    public function valid()
    {
        return !(feof($this->fd));
    }

    public function rewind()
    {
        $this->line_num = 0;
        fseek($this->fd, 0);
        $this->line = trim(fgets($this->fd));
    }

    public function next()
    {
        ++$this->line_num;
        $this->line = trim(fgets($this->fd));
    }
    public function key()
    {
        return $this->line_num;
    }
}
