<?php

namespace App\Providers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Env;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $geo_country = Helper::GET_GEO_COUNTRY_IP();
        Config::set('user_geo_country',$geo_country['geoplugin_countryCode'] ?? '');
        config(['APP_URL' => isset($_SERVER['SERVER_NAME']) ? 'https://'.$_SERVER["SERVER_NAME"] : null]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
