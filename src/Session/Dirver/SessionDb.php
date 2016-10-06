<?php

namespace shihunguilai\phpapi\Session\Dirver;

use shihunguilai\phpapi\Session\AbstrSession;

/**
 * CREATE TABLE if not exists `shihunguilai_session` (.
 session_id varchar(255) NOT NULL,
 session_expire int(11) NOT NULL,
 session_data blob,
 UNIQUE KEY `session_id` (`session_id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8
 * 2016年10月6日-下午10:32:01
 *
 * @author cliff zhang.<1058462838@qq.com>
 */
class SessionDb extends AbstrSession
{
    private static $handler = null;

    private static $prefix = '';

    private static $options = array(
        'host' => '127.0.0.1',
        'port' => '3306',
        'db_name' => 'test',
        'table' => 'shihunguilai_session',
        'user' => 'root',
        'password' => 'root',
        'maxlifetime' => null,
    );

    public function __construct($options = array())
    {
        if (!extension_loaded('mysqli')) {
            throw new \Exception('no mysqli extensions');
        }

        if (!(isset($options['maxlifetime']) && is_int($options['maxlifetime']) && $options['maxlifetime'] > 0)) {
            $options['maxlifetime'] = ini_get('session.gc_maxlifetime');
        }

        self::$options = array_merge(self::$options, $options);
    }

    public function open($save_path, $session_name)
    {
        if (self::$handler instanceof \mysqli) {
            return true;
        }
        $handler = new \mysqli(
            self::$options ['host'],
            self::$options ['user'],
            self::$options ['password'],
            self::$options ['db_name'],
            self::$options ['port']);
        if (mysqli_connect_errno()) {
            printf('找不到MySQL服务. 错误编号: %sn', mysqli_connect_error());
            exit();
        }
        $handler->query('set names utf8');
        self::$handler = $handler;
        self::$prefix = 'phpdb_session:';
        $this->gc(self::$options['maxlifetime']);

        return true;
    }

    public function getRealKey($session_id)
    {
        return self::$prefix.$session_id;
    }

    public function read($session_id)
    {
        $id = $this->getRealKey($session_id);
        $sql = ' select session_data from '.self::$options['table']." where session_id = '".$this->escapeString($id)."'";
//         echo $sql;exit;
        $tm = self::$handler->query($sql);
        if ($tm) {
            $da = mysqli_fetch_assoc($tm);

            return $da['session_data'];
        }

        return '';
    }

    public function escapeString($str)
    {
        return self::$handler->escape_string($str);
    }

    public function write($session_id, $session_data)
    {
        $id = $this->escapeString($this->getRealKey($session_id));
        $table = self::$options['table'];
        $expire = self::$options['maxlifetime'] + time();

        $sql = " replace into {$table} (session_id,session_expire,session_data) values ('{$id}','{$expire}','{$session_data}')"
            ;
        self::$handler->query($sql);
        if (self::$handler->affected_rows) {
            return true;
        }

        return false;
    }

    public function close()
    {
        if (self::$handler) {
            self::$handler->close();
        }

        return true;
    }

    public function destroy($session_id)
    {
        $id = $this->getRealKey($session_id);
        $sql = 'delete from '.self::$options['table'].' where session_id = \''.$this->escapeString($id)."'";
//         echo $sql;exit;
        self::$handler->query($sql);
        if (self::$handler->affected_rows) {
            return true;
        }

        return false;
    }

    public function gc($maxlifetime)
    {
        $sql = 'delete from '.self::$options['table'].' where session_expire <= '.time();
        self::$handler->query($sql);

        return false;
    }
}
