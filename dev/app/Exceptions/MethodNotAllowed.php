<?php

namespace App\Exceptions;

/**
 * Class MethodNotAllowed
 * @package App\Exceptions\API
 * 请求方法不支持
 * 资源只支持GET,POST，用DELETE去请求时会返回
 * 因为这个方法我还不支持
 */
class MethodNotAllowed extends APIException
{
//    const STATUS_CODE = 405;
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[40500,40599]
     */
    const BIZ_CODE_DEFAULT = 40500;
    const BIZ_METHOD_NOT_FOND = 40501;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '请求方法不支持',
        self::BIZ_METHOD_NOT_FOND => '请求方法没有找到',
    ];

    /**
     * MethodNotAllowed constructor.
     * @param int $code
     * @param null $message
     * @param array $allow 实际允许哪些操作，比如GET、POST、PUT、DELETE
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, $message = null, array $allow = [], \Exception $previous = null)
    {
        $headers = [];
        if ($allow) {
            $headers['Allow'] = strtoupper(implode(', ', $allow));
        }
        parent::__construct($code, $message, $previous, $headers);
    }
}
