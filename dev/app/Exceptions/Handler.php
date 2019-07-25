<?php
/**
 * author: chengluo
 * date: 2018-07-02
 * time: 21:21
 * mail: chengluo@hk01.com
 */

namespace App\Exceptions;

use App\Facades\Warn;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use BadMethodCallException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\Contract\APIExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof BadMethodCallException) {
            throw new NotFound(40404, ($request->path()) . ":请求路径没有找到", $e);
        } elseif ($e instanceof ModelNotFoundException) {
            $e = new NotFound(0, '请求资源未找到', $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new Forbidden(0, null, $e);
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $e = new MethodNotAllowed(0, null, [], $e);
        } elseif ($e instanceof NotFoundHttpException) {
            $e = new NotFound(0, '请求路径未找到', $e);
        } elseif ($e instanceof ValidationException) {
            $e = new ValidationFailed(0, null, $e->validator->getMessageBag(), $e);
        } elseif (!$e instanceof APIExceptionInterface) {
            if ($e->getPrevious()) {
                $msg = $e->getPrevious()->getMessage() . ' in '
                    . $e->getPrevious()->getFile() . ':' . $e->getPrevious()->getLine();
            } else {
                $msg = $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
            }
            $e = new InternalServerError(0, $msg, $e);
//            Warn::warnMoSystem($e);
        }
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return $response;
        }

        return parent::render($request, $e);
    }
}
