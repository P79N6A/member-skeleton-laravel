<?php

namespace App\Exceptions;

use Illuminate\Support\MessageBag;
use App\Exceptions\Contract\MessageBagErrors;

/**
 * Class ValidationFailed
 * @package App\Exceptions\API
 * 数据验证失败
 * 在POST、PUT时候请求的JSON未通过Validation验证
 */
class ValidationFailed extends APIException implements MessageBagErrors
{
    const STATUS_CODE = 200;

    /**
     * 更多业务Code定义区间为[42200,42299]
     */
    const BIZ_CODE_DEFAULT = 4422;
    const BIZ_RESOURCE_NOT_FOUND = 44000;
    const BIZ_VALIDATE_FAILED = 44001;


    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '数据未通过验证',
        self::BIZ_RESOURCE_NOT_FOUND => '资源没有找到',
        self::BIZ_VALIDATE_FAILED => '数据未通过验证',

    ];

    /**
     * MessageBag errors.
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * ValidationFailed constructor.
     * @param int $code
     * @param null $message
     * @param null $errors
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, $message = null, $errors = null, \Exception $previous = null)
    {
        if (is_null($errors)) {
            $this->errors = new MessageBag;
        } elseif (is_array($errors)) {
            $this->errors = new MessageBag($errors);
        } elseif ($errors instanceof MessageBag) {
            $this->errors = $errors;
        }
        parent::__construct($code, $message, $previous);
    }

    /**
     * Get the errors message bag.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Determine if message bag has any errors.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return $this->errors ? !$this->errors->isEmpty() : false;
    }
}
