<?php

namespace App\Services\System;

class TraceMsg
{
    private static $traceId= 0;

    /**
     * TraceMsg constructor.
     */
    public function __construct()
    {
    }

    public function traceIdMaker()
    {
        // params 为机器id
        $Idwork = new TraceIdGenerator(1);
        return  $Idwork->nextId();
    }

    
    //一次请求生成同一个id
    public static function singletonTraceIdMaker()
    {
        // params 为机器id
        if (!self::$traceId) {
            $Idwork = new TraceIdGenerator(1);
            self::$traceId = $Idwork->nextId();
        }
        return  self::$traceId;
    }
}
