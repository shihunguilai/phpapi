<?php

namespace shihunguilai\phpapi\Session;

interface ISession
{
    public function begin();

    /**
     * 自动开始回话或者session_start()开始回话后第一个调用的函数
     * 类似于构造函数的作用.
     *
     * @param string $save_path
     * @param string $session_name
     *                             2016年10月6日-下午7:01:43
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function open($save_path, $session_name);

    /**
     * 类似于析构函数，在write之后调用或者session_write_close()函数之后调用.
     *
     * 2016年10月6日-下午7:02:13
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function close();

    /**
     * 读取session信息.
     *
     * @param $sessionId 通过该Id唯一确定对应的session数据
     * 2016年10月6日-下午7:02:39
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function read($session_id);

    /**
     * 写入或者修改session数据.
     *
     * @param $session_id 要写入数据的session对应的id
     * @param $session_data 要写入的数据，已经序列化过了
     */
    public function write($session_id, $session_data);

    /**
     *  清理会话中的过期数据.
     *
     * @param int $maxlifetime
     *                         2016年10月6日-下午7:03:19
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function gc($maxlifetime);

    /**
     * * 主动销毁session会话.
     *
     * @param string $session_id 要销毁的会话的唯一id
     *                           2016年10月6日-下午7:04:00
     *
     * @author  cliff zhang.<1058462838@qq.com>
     */
    public function destory($session_id);
}
