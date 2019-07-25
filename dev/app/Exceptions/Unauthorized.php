<?php

namespace App\Exceptions;

/**
 * Class Unauthorized
 * @package App\Exceptions\API
 * 无法验证用户身份
 * 可能是用户请求时没有传递身份信息
 */
class Unauthorized extends APIException
{
//    const STATUS_CODE = 401;
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[40100,40199]
     */
    const BIZ_CODE_DEFAULT = 40100;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '无法验证用户身份',
    ];

    /**
     * Unauthorized constructor.
     * @param int $code
     * @param null $message
     * @param null $challenge 可以使用什么样的验证方式进行验证
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, $message = null, $challenge = null, \Exception $previous = null)
    {
        $headers = [];
        if ($challenge) {
            $headers['WWW-Authenticate'] = $challenge;
        }
        parent::__construct($code, $message, $previous, $headers);
    }
}
