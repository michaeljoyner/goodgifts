<?php

namespace App\Providers;

use App\Amazon\AmazonSimilarSearch;
use App\Analytics\AnalyticsData;
use App\Analytics\FakeAnalyticsData;
use App\Analytics\GoogleAnalyticsData;
use App\Products\AmazonProductSearch;
use App\Products\Lookup;
use App\Products\ProductSearch;
use App\Products\SimilarSearch;
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
        $this->app->bind(ProductSearch::class, function() {
           return new AmazonProductSearch();
        });

        $this->app->bind(Lookup::class, function() {
            return new \App\Amazon\ProductLookup;
        });

        $this->app->bind(SimilarSearch::class, function() {
            return new AmazonSimilarSearch();
        });

        $this->app->bind(AnalyticsData::class, function() {
            return new GoogleAnalyticsData();
        });
    }
}
