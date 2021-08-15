<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // $aksesId = rand().'-'.hash_hmac('md5',now(),'wek');
        // DB::listen(function ($query) use ($aksesId) {
        //     // $query->sql
        //     // $query->bindings
        //     // $query->time
        //     if(true){//stripos($query->sql,'absensi')!=false && stripos($query->sql,'select')===false){
        //         $sql = str_replace('?', "'?'", $query->sql);
        //         $sql = vsprintf(str_replace('?', '%s', $sql), $query->bindings);                
        //         Log::info('[QUERY] ['.$aksesId.'] : '.$sql);
        //     }
        // });
    }
}
