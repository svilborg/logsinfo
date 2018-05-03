<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use gchart\gPieChart;

class gPieChartProvider extends ServiceProvider
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
    public function register()
    {
        $this->app->singleton('gchart\gPieChart', function ($app) {
            return new gPieChart(550);
        });
    }
}
