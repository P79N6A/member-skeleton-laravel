<?php

namespace App\Services\System\Logging;

use Monolog\Formatter\LineFormatter;
use App\Facades\CommonFunc;

class SaaSLogFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($this->getDefaultFormatter());
        }
    }

    protected function getDefaultFormatter()
    {
        $this->request = !app()->runningInConsole() ? app('request') : null;
        $rid = $this->request->header('REQUESTID');
        $requestId = empty($rid)?getenv("REQUESTID"):$rid;
        $environment = getenv('PROJECT_ENV')?getenv("PROJECT_ENV"):"dev";
        $userIp = CommonFunc::getClientRealIp();
        $requestPath = is_null($this->request) ? "" : $this->request->path();
        $userId = empty($this->request->header('USERID'))?"Anonymous":$this->request->header('USERID');

        $LINEFORMAT = "[$requestId] [%datetime%] [$environment] [$userId]  [$userIp] [$requestPath] [%level_name%]\n %message% %context%\n";
        return new LineFormatter($LINEFORMAT, null , true, true);
    }
}