<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Parsers\ParserStrategy;

class ParserStrategyProvider extends ServiceProvider
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

        $this->app->singleton(ParserStrategy::class, function ($app) {
            return new ParserStrategy();
        });
    }
}
