<?php
namespace App\Http\Middleware;

use Closure;
use Log;
use Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class BaseMiddleware
{

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct()
    {
    }

    

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        Log::info('request begin -------------------------------------------- ');
        //Log::info($_SERVER);
        $env=array();
        foreach ($_SERVER as $key => $value) {
            if (in_array($key, [
                'REQUEST_URI','HTTP_HOST','SERVER_ADDR','REQUEST_METHOD'
            ]) || strpos($key, '_X_')!==false ) {
                $env[$key] = $value;
            }
        }
        Log::info('request env', $env);
        if (!empty($_POST)) {
            Log::info('request _POST:', $_POST);
        }
        if (!empty($_FILES)) {
            Log::info('request _FILES:', $_FILES);
        }
        $content = file_get_contents("php://input");
        if (!empty($content)) {
            Log::info('request body:', array($content));
        }

        $header = empty(\Request::header())?"no header info":json_encode(\Request::header());
        Log::info($header);
        
        $begin_time = microtime(true);
        $response =  $next($request);

        $end_time = microtime(true);
        $memory =  round(memory_get_usage()/1024/1024, 3);

        Log::info("request end --------------------------------------------  request status : ", ['time' => round($end_time - $begin_time, 4).'s','memory'=>$memory.'M']);
        

        if (isset($_SERVER['SERVER_ADDR'])) {
            return $response->header('Serverd', $_SERVER['SERVER_ADDR']);
        }

        return $response->header('Serverd', null);
    }
}
