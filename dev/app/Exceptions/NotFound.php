<?php

namespace App\Exceptions;

/**
 * Class NotFound
 * @package App\Exceptions\API
 * 请求资源未找到
 * 用户请求某资源但是没有找到
 */
class NotFound extends APIException
{
    const STATUS_CODE = 404;

    /**
     * 更多业务Code定义区间为[40400,40499]
     */
    const BIZ_CODE_DEFAULT = 40400;
    const BIZ_CODE_NOT_FOUND = 40401;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '请求资源未找到',
        self::BIZ_CODE_NOT_FOUND => '请求资源未找到',
    ];
}
