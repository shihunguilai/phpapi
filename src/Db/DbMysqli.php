<?php

namespace shihunguilai\phpapi\Db;

class DbMysqli
{
    private $db_config;
    private $db;
    private static $instance;
    private $lastSql;

    private function __construct()
    {
        $this->initDb();
    }

    public static function getInstance()
    {
        if (!(self::$instance && self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function initDb()
    {
        $this->db_config = require_once dirname(__FILE__).'/db.config.php';

        $this->db = new \mysqli(
            $this->db_config ['host'],
            $this->db_config ['username'],
            $this->db_config ['password'],
            $this->db_config ['db_name'],
            $this->db_config ['port']);
        if (mysqli_connect_errno()) {
            printf('找不到MySQL服务. 错误编号: %sn', mysqli_connect_error());
            exit();
        }
        $this->db->query('set names utf8');
    }

    public function __destruct()
    {
        $this->close();
    }
    public function getInsertSql($table, $arr = array())
    {
        $sql = "insert into  {$table}(`";
        $sql .= implode('`,`', array_keys($arr));
        $sql .= "`) values ('";
        $sql .= implode("','", array_values($arr));
        $sql .= "')";

        return $sql;
    }
    public function add($table, $arr = array())
    {
        $this->lastSql = $this->getInsertSql($table, $arr);
        $this->query($this->lastSql);

        return $this->db->insert_id;
    }

    /**
     * [addAll description].
     *
     * @param [type] $table [description]
     * @param array  $arr   [description]
     *                      2016-4-11 19:18
     */
    public function addAll($table, $arr = array())
    {
        if (empty($arr)) {
            return false;
        }

        $sql = "insert into  {$table}(`";
        $sql .= implode('`,`', array_keys($arr[0]));
        $sql .= '`) values ';

        $this->escape_db_query_arr($arr);

        foreach ($arr as $key => $value) {
            $sql .= "('".implode("','", $value)."'),";
        }

        $sql = substr($sql, 0, strlen($sql) - 1);

        $this->lastsql = $sql;

        return $this->db->query($sql);
    }

    public function save($table, $arr = array(), $where = array())
    {
        if (empty($arr)) {
            return false;
        }
        $sql = " update {$table} set ";
        $value_sql = '';
        foreach ($arr as $key => $value) {
            if ($value_sql != '') {
                $value_sql .= ',';
            }
            $value = $this->escape_db_query($value);
            $value_sql .= " `{$key}` = '{$value}' ";
        }
        $where_sql = '';
        foreach ($where as $key => $value) {
            if ($where_sql == '') {
                $where_sql = '  where  ';
            } else {
                $where_sql .= '  and  ';
            }
            $where_sql .= "  `{$key}` = '{$value}' ";
        }

        $this->lastSql = $sql.$value_sql.$where_sql;

        return $this->query($this->lastSql);
    }

    public function getLastSql()
    {
        return $this->lastSql;
    }

    public function query($sql)
    {
        $this->lastSql = $sql;

        return $this->db->query($sql);
    }

    /**
     * @param unknown $sql
     *
     * @return multitype:unknown
     *                           2016-4-21-下午5:06:13
     */
    public function queryList($sql)
    {
        $this->lastSql = $sql;
        $rr = $this->db->query($this->lastSql);
        $ret = array();
        while ($row = mysqli_fetch_assoc($rr)) {
            $ret[] = $row;
        }
        $rr->close();

        return $ret;
    }

    public function asyncQueryList($sql)
    {
        $this->lastSql = $sql;
        $rr = $this->db->query($this->lastSql);
        $ret = array();
        while ($row = mysqli_fetch_assoc($rr)) {
            yield $row;
        }
        $rr->close();
        //        return $ret;
    }

    public function close()
    {
        if ($this->db) {
            $this->db->close();
        }
    }

    /**
     * @param unknown $str
     *                     2016-4-21-下午4:51:39
     */
    public function escape_db_query($str)
    {
        return $this->db->escape_string($str);
    }

    /**
     * @param unknown $arr
     *                     2016-4-25-下午4:13:59
     */
    public function escape_db_query_arr(&$arr)
    {
        array_walk_recursive($arr, array(__CLASS__, 'escape_db_query'));
    }
}
