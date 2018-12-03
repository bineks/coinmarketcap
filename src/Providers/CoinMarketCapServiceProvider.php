<?php

namespace Bineks\Coinmarketcap\Providers;

use Bineks\Coinmarketcap\Services\CoinMarketCap;
use Illuminate\Support\ServiceProvider;

/**
 * Class CoinMarketCapServiceProvider.
 */
class CoinMarketCapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CoinMarketCap', function ($app) {
            return new CoinMarketCap($app);
        });
    }
}
