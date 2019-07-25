<?php
/**
 * author: Ethan
 * mail: chengluo@hk01.com
*/

namespace App\Facades ;

use Auth;

class CommonFunc
{
    /**
     * 获取客户端IP
     * @return ip
     */
    public static function getClientRealIp()
    {
        if (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = explode(',', getenv("HTTP_X_FORWARDED_FOR"))[0];
        } elseif (getenv("HTTP_X_REAL_IP")) {
            $ip = getenv("HTTP_X_REAL_IP");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "unknow or localhost";
        }
        
        return trim($ip);
    }
}
