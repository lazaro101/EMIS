<?php

namespace app\Providers;

use Illuminate\Support\ServiceProvider;

use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){   
        // view()->composer('layouts.admin', function($view){
        //     $general = DB::table('settings_general')->get();
        //     $view->with('variable', $general);
        // });
        // view()->composer('layouts.web', function($view){
        //     $general = DB::table('settings_general')->get();
        //     $view->with('variable', $general);
        // });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
