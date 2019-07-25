<?php
/**
 * author: Ethan
 * mail: chengluo@hk01.com
*/

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Monolog;
use Writer;


class LogServiceProvider extends ServiceProvider
{
   public function register()
    {
        $this->app->singleton('log', function () {
            return $this->createLogger();
        });
    }

    public function createLogger()
    {
        $monolog = new Monolog($this->channel());
        $log = new Writer($monolog, $this->app['events']);

        # 初始化Handler
        $this->configureHandler($log);

        return $log;
    }

    protected function configureHandler(Writer $log)
    {
        $this->{'configure'.ucfirst($this->handler()).'Handler'}($log);
    }


    protected function configureDailyHandler(Writer $log)
    {
        $log->useDailyFiles(
            $this->app->storagePath().config('app.logging.debug.path'), $this->maxFiles(),
            $this->logLevel()
        );
    }

}



