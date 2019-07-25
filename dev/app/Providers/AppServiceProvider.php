<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\System\TraceMsg;
use Illuminate\Support\Facades\Config;
use Log;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $request_id = (new TraceMsg())->traceIdMaker();
        putenv('REQUESTID='.$request_id);
        // putenv('app.username='.(empty($_COOKIE['AdsUserName'])?'Anonymous':$_COOKIE['AdsUserName']));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            $sql = $query->sql;
            $bindings = $query->bindings;
            $time = round($query->time,3);
            $sql = str_replace("%", "'%%'", $sql);
            $sql = str_replace("?", "'%s'", $sql);
            $msg = "SQL: " . vsprintf($sql, $bindings)." [exec time: ${time}ms]";
            Log::info($msg);

            
        });
    }
}
