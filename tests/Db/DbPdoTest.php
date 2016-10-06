<?php

namespace shihunguilai\phpapi\Db;

class DbPdoTest extends \PHPUnit_Framework_TestCase
{
    private $instance;

    public function setUp()
    {
        $this->markTestSkipped(' not to test;');

        return false;

        if (!class_exists('PDO')) {
            $this->markTestSkipped(' no pdo extension');

            return false;
        }
        $config = array(
            'dns' => 'mysql:dbname=test;host=localhost;port=3306',
            'user' => 'root',
            'password' => 'root',
        );
        $this->instance = DbPdo::getInstance($config);
    }

    public function testShowtables()
    {
        $sql = <<<'eof'
        create table if not exists user(
          id int unsigned auto_increment key,
            username varchar(20) not null unique,
            password char(32) not null,
            email varchar(30) not null
        );
eof;
        $sql = "INSERT user22(username,password,email) VALUES ('php','php','php@12.com')";
        var_dump($this->instance->exec($sql));
        print_r($this->instance->getError());
//         var_dump($this->instance);
//             var_dump($this->instance->exec($sql) or die(print_r($this->instance->errorInfo(), true)));
    }
}
