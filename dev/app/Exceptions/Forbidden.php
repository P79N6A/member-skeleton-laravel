<?php

namespace App\Exceptions;

/**
 * Class Forbidden
 * @package App\Exceptions\API
 * 用户无权操作
 * 用户身份已经验证，但是查看权限后发现无权操作
 */
class Forbidden extends APIException
{
//    const STATUS_CODE = 403;
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[40300,40399]
     */
    const BIZ_CODE_DEFAULT = 40300;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '无权进行该操作',
    ];
}
