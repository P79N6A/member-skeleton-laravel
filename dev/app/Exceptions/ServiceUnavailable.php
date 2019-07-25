<?php

namespace App\Exceptions;

/**
 * Class ServiceUnavailable
 * @package App\Exceptions\API
 * 服务暂不可用
 * 出现短暂可恢复错误时返回此错误
 */
class ServiceUnavailable extends APIException
{
//    const STATUS_CODE = 503;
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[50300,50399]
     */
    const BIZ_CODE_DEFAULT = 50300;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '服务暂不可用',
    ];

    /**
     * ServiceUnavailable constructor.
     * @param int $code
     * @param null $message
     * @param null $retryAfter 可以在多少秒之后进行重试
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, $message = null, $retryAfter = null, \Exception $previous = null)
    {
        $headers = [];
        if ($retryAfter) {
            $headers['Retry-After'] = $retryAfter;
        }
        parent::__construct($code, $message, $previous, $headers);
    }
}
