<?php

namespace App\Exceptions;

/**
 * Class TooManyRequests
 * @package App\Exceptions\API
 * 请求次数过多
 * 触发限流警告，需要客户降速请求。
 */
class TooManyRequests extends APIException
{
//    const STATUS_CODE = 429;
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[42900,42999]
     */
    const BIZ_CODE_DEFAULT = 42900;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '请求次数过多',
    ];

    /**
     * TooManyRequests constructor.
     * @param int $code
     * @param null $message
     * @param null $limit 限制次数是一分钟多少次
     * @param null $remain 还剩多少次可以请求
     * @param null $reset 在什么时间会重置计数
     * @param \Exception|null $previous
     */
    public function __construct(
        $code = 0,
        $message = null,
        $limit = null,
        $remain = null,
        $reset = null,
        \Exception $previous = null
    ) {
        $headers = [];
        if ($limit) {
            $headers['X-RateLimit-Limit'] = $limit;
        }
        if ($remain) {
            $headers['X-RateLimit-Remaining'] = $remain;
        }
        if ($reset) {
            $headers['X-RateLimit-Reset'] = $reset;
        }
        parent::__construct($code, $message, $previous, $headers);
    }
}
