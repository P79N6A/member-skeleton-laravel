<?php

namespace App\Exceptions;

/**
 * Class InternalServerError
 * @package App\Exceptions\API
 * 服务内部错误
 * 接口内又去调用其他服务，但是出现失败无法恢复
 */
class InternalServerError extends APIException
{
    const STATUS_CODE = 500;

    /**
     * 更多业务Code定义区间为[50500,59999]
     */
    const BIZ_CODE_DEFAULT = 5500;
    const BIZ_ONS_NOT_FOUND_HOST = 50501;
    const BIZ_SERVCIE_INTERNAL_ERROR = 50502;
    const BIZ_CLIENT_REQUEST_SERVICE_ERROR = 50503;
    const BIZ_LOG_WARN_RIGHT_ERROR = 50509;
    const BIZ_ORDER_AUDIT_ROLLBACK_FAILED_ERROR = 50510;
    const BIZ_FILE_MIME_CHECK_ERROR = 50511;
    const BIZ_FILE_UPLOAD_ERROR = 50512;
    const BIZ_FILE_CHECK_ERROR = 50513;
    const BIZ_SERVER_RESPONSE_JSON_ERROR = 50514;
    const BIZ_GET_AD_ID_ERROR = 50515;
    const BIZ_DB_INSERT_ERROR = 50520;
    const BIZ_DB_DELETE_ERROR = 50521;
    const BIZ_DB_SELECT_ERROR = 50522;
    const BIZ_DB_UPDATE_ERROR = 50523;
    const BIZ_ES_CRUD_ERROR_CODE = 50593;
    const BIZ_OPEN_REQUEST_ERROR_CODE = 50594;


    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '服务内部错误',
        self::BIZ_ONS_NOT_FOUND_HOST => 'ONS没有找到与Key对应的HOST',
        self::BIZ_SERVCIE_INTERNAL_ERROR => '服务端请求异常',
        self::BIZ_CLIENT_REQUEST_SERVICE_ERROR => '服务端请求异常',
        self::BIZ_LOG_WARN_RIGHT_ERROR => '服务端告警日志权限异常',
        self::BIZ_ORDER_AUDIT_ROLLBACK_FAILED_ERROR => 'Order审批回调异常',
        self::BIZ_FILE_MIME_CHECK_ERROR => '文件类型不支持',
        self::BIZ_FILE_UPLOAD_ERROR => '文件上传失败',
        self::BIZ_FILE_CHECK_ERROR => '文件验证失败',
        self::BIZ_SERVER_RESPONSE_JSON_ERROR => '服务端异常或服务端数据返回非Code-Message的JSON格式',
        self::BIZ_GET_AD_ID_ERROR => 'Ad_id不存在或获取失败',
        self::BIZ_DB_INSERT_ERROR => '数据库插入操作失败',
        self::BIZ_DB_DELETE_ERROR => '数据库删除操作失败',
        self::BIZ_DB_SELECT_ERROR => '数据库查询操作失败',
        self::BIZ_DB_UPDATE_ERROR => '数据库更新操作失败',
        self::BIZ_ES_CRUD_ERROR_CODE => '同步Order数据到ES失败, CRUD操作异常',
        self::BIZ_OPEN_REQUEST_ERROR_CODE => 'OPEN请求异常',
    ];
}
