<?php

namespace App\Exceptions;

/**
 * Class UnsupportedMediaType
 * @package App\Exceptions\API
 * 请求的媒体格式不支持
 * 例如只支持JSON，用户请求YAMl
 */
class UnsupportedMediaType extends APIException
{
//    const STATUS_CODE = 415;
    const STATUS_CODE = 200;
    /**
     * 更多业务Code定义区间为[41500,41599]
     */
    const BIZ_CODE_DEFAULT = 41500;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '请求的媒体格式不支持',
    ];
}
