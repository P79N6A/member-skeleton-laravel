<?php

namespace App\Exceptions;

/**
 * Class BadRequest
 * @package App\Exceptions\API
 * 客户请求出错
 * 如果实在不好放到别的异常里面的时候可以扔这个
 */
class BadRequest extends APIException
{
//    const STATUS_CODE = 400;
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[40000,40099]
     */
    const BIZ_CODE_DEFAULT = 40000;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '用户请求有误',
    ];
}
