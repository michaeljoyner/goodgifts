<?php

namespace App\Providers;

use App\Analytics\AnalyticsData;
use App\Analytics\FakeAnalyticsData;
use App\Analytics\GoogleAnalyticsData;
use App\Products\Lookup;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Lookup::class, function() {
            return new \App\Amazon\ProductLookup;
        });

        $this->app->bind(AnalyticsData::class, function() {
            return new GoogleAnalyticsData();
        });
    }
}
