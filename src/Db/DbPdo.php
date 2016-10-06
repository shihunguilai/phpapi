<?php

namespace shihunguilai\phpapi\Db;

class DbPdo
{
    private static $instance;
    private $handler;
    private $lastSql;
    private $lastInstertId;
    private $errorCode;
    private $errorInfo;

    private function __construct($config)
    {
        $this->init($config);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    private function init(array $config)
    {
        try {
            $this->handler = new \PDO($config['dns'], $config['user'], $config['password']);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
//         var_dump($this->handler);
    }

    public static function getInstance($config)
    {
        if (!(self::$instance && self::$instance instanceof  self)) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function getError()
    {
        return array(
            'code' => $this->errorCode,
            'info' => $this->errorInfo,
        );
    }

    public function setError()
    {
        $this->errorCode = $this->handler->errorCode();
        $this->errorInfo = $this->handler->errorInfo();
    }

    public function getLastInsertId()
    {
        return $this->handler->lastInsertId();
    }

    /**
     * @param string $sql
     *
     * @return number
     *                2016年10月5日-下午6:35:40
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function exec($sql)
    {
        try {
            $rs = $this->handler->exec($sql);
        } catch (\PDOException $e) {
            $rs = false;
        }
        if ($rs === false) {
            $this->setError();
        }

        return $rs;
    }

    public function __call($fun_name, $args)
    {
        if (method_exists($this->handler, $fun_name)) {
            return call_user_func_array(array($this->handler, $fun_name), $args);
        } else {
            throw new \Exception('method not in '.$this->handler);
        }
    }
}
