<?php

namespace App\Services\System;

/**
 * ID 生成策略
 * 毫秒级时间41位+机器ID 10位+毫秒内序列12位。
 * 0           41     51     64
 * +-----------+------+------+
 * |time       |pc    |inc   |
 * +-----------+------+------+
 *  前41bits是以微秒为单位的timestamp。
 *  接着10bits是事先配置好的机器ID。
 *  最后12bits是累加计数器。
 *  macheine id(10bits)标明最多只能有1024台机器同时产生ID，sequence number(12bits)也标明1台机器1ms中最多产生4096个ID，
 *
 */
class TraceIdGenerator
{
    const DEBUG = 1;
    const WORKER_ID_BITS = 4;
    const SEQUENCE_BITS = 10;

    public static $workerId;
    public static $twepoch = 1361775855078;
    public static $sequence = 0;
    public static $maxWorkerId = 15;
    public static $workerIdShift = 10;
    public static $timestampLeftShift = 14;
    public static $sequenceMask = 1023;
    private static $lastTimestamp = -1;

    public function __construct($params)
    {
        $workId = $params['workId'];
        if ($workId > self::$maxWorkerId || $workId < 0) {
            throw new Exception("worker Id can't be greater than 15 or less than 0");
        }
        self::$workerId = $workId;
    }

    public function timeGen()
    {
        //获得当前时间戳
        $time = explode(' ', microtime());
        $time2 = substr($time[0], 2, 3);
        return $time[1] . $time2;
    }

    public function tilNextMillis($lastTimestamp)
    {
        $timestamp = $this->timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }

        return $timestamp;
    }

    public function nextId()
    {
        $timestamp = $this->timeGen();
        if (self::$lastTimestamp == $timestamp) {
            self::$sequence = (self::$sequence + 1) & self::$sequenceMask;
            if (self::$sequence == 0) {
                $timestamp = $this->tilNextMillis(self::$lastTimestamp);
            }
        } else {
            self::$sequence = 0;
        }
        if ($timestamp < self::$lastTimestamp) {
            throw new Excwption("Clock moved backwards.  Refusing to generate id for " .
                (self::$lastTimestamp - $timestamp) . " milliseconds");
        }
        self::$lastTimestamp = $timestamp;
        $nextId = ((sprintf('%.0f', $timestamp) - sprintf('%.0f', self::$twepoch))
                << self::$timestampLeftShift) | (self::$workerId << self::$workerIdShift) | self::$sequence;
        return $nextId;
    }
}
