<?php

namespace App\Exceptions;

/**
 * Class Conflict
 * @package App\Exceptions\API
 * 乐观锁冲突
 * 更新同一个数据时因为乐观锁问题发生冲突
 */
class Conflict extends APIException
{
//    const STATUS_CODE = 409;
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[40900,40999]
     */
    const BIZ_CODE_DEFAULT = 40900;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '发生冲突',
    ];
}
