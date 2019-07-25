<?php

/**
 * author: chengluo
 * date: 2018-07-02
 * time: 21:21
 * mail: chengluo@hk01.com
 */

namespace App\Exceptions;

use App\Exceptions\Contract\MessageBagErrors;
use App\Exceptions\Contract\APIExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Log;

abstract class APIException extends HttpException implements APIExceptionInterface
{
    const STATUS_CODE = 500;

    const BIZ_CODE_DEFAULT = 5500;

    const MESSAGE_MAP = [
        self::BIZ_CODE_DEFAULT => '服务内部错误',
    ];

    protected $dataMsg;

    public function __construct(
        $code = 0,
        $message = null,
        $dataMsg = null,
        \Exception $previous = null,
        array $headers = []
    ) {
        $code = (!empty($code) && isset(static::MESSAGE_MAP[$code])) ? $code : static::BIZ_CODE_DEFAULT;
        $message = !empty($message) ? $message : static::MESSAGE_MAP[$code];
        $this->dataMsg = $dataMsg;
        parent::__construct(static::STATUS_CODE, $message, $previous, $headers, $code);
    }

    public function render($request)
    {
        $data = [
            'code' => $this->getCode(),
            'msg' => $this->getMessage(),
        ];
        if ($this instanceof MessageBagErrors and $this->hasErrors()) {
//            $data['data'] = $this->getErrors();
            $error_temp = array();
            foreach ($this->getErrors()->messages() as $key => $error) {
                $error_temp[] = implode(" ", $error);
            }
            $data['msg'] = implode(" ", $error_temp);
        } elseif ($this instanceof InternalServerError and config('app.debug')) {
            $e = $this->getPrevious() ? $this->getPrevious() : $this;
            $data['data'] = [
                'class' => get_class($e),
                'message' => $this->getMessage(),
                'code' => $this->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => explode("\n", $e->getTraceAsString()),
            ];
        }
        try {
            $response = response()->json($data)->setStatusCode($this->getStatusCode());
            $headers = $this->getHeaders();
            foreach ($headers as $key => $val) {
                $response->header($key, $val, true);
            }

            $errorMsg = [
                'error' => $data,
                'data' => empty($this->dataMsg) && !is_int($this->dataMsg) ? '' : $this->dataMsg,
            ];
            Log::error(json_encode($errorMsg));
            return $response;
        } catch (\Exception $e) {
            header("Content-type:application/json;");
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
            die();
        }
    }
}
