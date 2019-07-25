<?php

namespace App\Exceptions;

/**
 * Class ServicesException
 * @package App\Exceptions\API
 * WePro服务业务异常
 */
class ServicesException extends APIException
{
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[70000,79999]
     */
    const BIZ_CODE_DEFAULT = 75000;

    // 查询条件逻辑
    const BIZ_SEARCH_CONDITION_UPDATE_FAILED = 70100;
    const BIZ_SEARCH_CONDITION_INSERT_FAILED = 70101;
    const BIZ_SEARCH_CONDITION_DELETE_FAILED = 70102;
    const BIZ_SEARCH_CONDITION_SELECT_FAILED = 70103;
    const BIZ_SEARCH_CONDITION_EXCEED_MAX = 70104;
    const BIZ_SEARCH_CONDITION_EXSIST = 70105;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => 'WePro服务异常',

        self::BIZ_SEARCH_CONDITION_UPDATE_FAILED => '更新自定义查询条件失败',
        self::BIZ_SEARCH_CONDITION_INSERT_FAILED => '保存自定义查询条件失败',
        self::BIZ_SEARCH_CONDITION_DELETE_FAILED => '删除自定义查询条件失败',
        self::BIZ_SEARCH_CONDITION_SELECT_FAILED => '查询自定义查询条件失败',
        self::BIZ_SEARCH_CONDITION_EXCEED_MAX => '最多只能保存5条常用查询条件',
        self::BIZ_SEARCH_CONDITION_EXSIST => '查询条件已存在',
    ];
}
