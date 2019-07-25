<?php

namespace App\Services\System;

use App\Exceptions\InternalServerError;
use Request;

class WarnService
{
    protected $request;
    public function __construct()
    {
    }

    // 日志告警
    public function warnMoSystem($e)
    {
        $file = '/data/logs/log_monitor/default/'.date('Ymd').".log";
        if (!file_exists(dirname($file))) {
            umask(0000);
            try {
                @mkdir(dirname($file), 0777, true);
                @chmod($file, 0777);
            } catch (\Exception $e) {
                throw new InternalServerError(50509);
            }
        }
        $this->warnMoSystemTxt($e->getMessage());
    }

    // 日志告警
    public function warnMoSystemTxt($txt)
    {
        $file = '/data/logs/log_monitor/default/'.date('Ymd').".log";
        if (!file_exists($file)) {
            umask(0000);
            @mkdir(dirname($file), 0777, true);
            @chmod($file, 0777);
        }
        $fp = @fopen($file, 'a');
        if ($fp) {
            $errormsg = '['.date('Y-m-d H:i:s').'][ERROR] ';
            if (!empty($this->request)) {
                $path = !empty($this->request->path())?$this->request->path():"/";
                $params = !empty($this->request->input())?json_encode($this->request->input()):"";
                $ip = !empty($this->request->ip())?$this->request->ip():"";

                $errormsg .= 'request_path:'.$path.';';
                $errormsg .= 'request_params:'.$params.';';
                $errormsg .= 'request_ip:'.$ip.';';
            }
            $txt = str_replace(array('[',']','"','\\'), array('<','>','',''), $txt);
            try {
                $errormsg .= 'error_msg:'.iconv('utf-8', 'gbk', $txt);
            } catch (\Exception $e) {
                $errormsg .= 'error_msg:'.$txt;
            }

            $errormsg .= "\n";
            
            @fputs($fp, $errormsg);
            @fclose($fp);
        }
    }
}
