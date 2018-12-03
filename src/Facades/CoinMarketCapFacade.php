<?php

namespace Bineks\Coinmarketcap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CoinMarketCapFacade.
 */
class CoinMarketCapFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Bineks\Coinmarketcap\Services\CoinMarketCap::class;
    }
}
