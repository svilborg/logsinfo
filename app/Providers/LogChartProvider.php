<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\LogChart;
use gchart\gPieChart;

class LogChartProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LogChart::class, function ($app) {
            return new LogChart(new gPieChart(550));
        });
    }
}
