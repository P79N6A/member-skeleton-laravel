<?php
namespace App\Services\System;

class Msg
{
    /**
     * 消息参数个数
     */
    protected $arg_num = 0;
    /**
     * 消息状态码，一般0表示成功
     */
    protected $code = 0;

    /**
     * 消息的描述
     */
    protected $msg = '';


    /**
     * 消息中返回的数据
     */
    protected $data = array();

    /**
     * 二次确认id等信息
     */
    protected $action = array();


    /**
     * 构造函数
     */
    public function __construct()
    {
        $arg_num = func_num_args();
        $this->arg_num = $arg_num;
        $args = func_get_args();
        if ($arg_num == 1) {
            $this->successMsg($args[0]);
        }
        if ($arg_num == 2) {
            $this->msgWithoutData($args[0], $args[1]);
        }
        if ($arg_num == 3) {
            $this->detialMsg($args[0], $args[1], $args[2]);
        }
        if ($arg_num == 4) {
            $this->twiceCheckMsg($args[0], $args[1], $args[2], $args[3]);
        }
    }


    private function successMsg($data)
    {
        $this->message = 'success';
        $this->code = 0;
        $this->data = $data;
    }

    private function msgWithoutData($code, $msg)
    {
        $this->code = $code;
        $this->message = $msg;
    }

    private function detialMsg($code, $msg, $data)
    {
        $this->code = $code;
        $this->message = $msg;
        $this->data = $data;
    }

    private function twiceCheckMsg($code, $msg, $data, $action)
    {
        $this->code = $code;
        $this->message = $msg;
        $this->data = $data;
        $this->action = $action;
    }

    public function __toString()
    {
        switch ($this->arg_num) {
            case 1:
            case 2:
                $ret = array(
                    'code' => $this->code,
                    'message'  => $this->msg,
                );
                break;
            case 3:
                $ret = array(
                    'code' => $this->code,
                    'message'  => $this->msg,
                    'data' => $this->data,
                );
                break;

            case 4:
                $ret = array(
                    'code' => $this->code,
                    'message'  => $this->msg,
                    'data' => $this->data,
                    'action' => $this->action,
                );
                break;
        }


        //if(empty($ret['data'])) unset($ret['data']);
        return json_encode($ret);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function getData()
    {
        return $this->data;
    }
    
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }


    public function toArray()
    {

        switch ($this->arg_num) {
            case 2:
                return [
                    'code' => $this->code,
                    'message'  => $this->msg,
                ];
                break;
            case 1:
            case 3:
                return [
                    'code' => $this->code,
                    'message' => $this->msg,
                    'data' => $this->data,
                ];
                break;

            case 4:
                return [
                    'code' => $this->code,
                    'message' => $this->msg,
                    'data' => $this->data,
                    'action' => $this->action,
                ];
                break;
        }
    }
}
