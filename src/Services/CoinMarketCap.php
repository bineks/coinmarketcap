<?php

namespace Bineks\Coinmarketcap\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Class CoinMarketCap
 * @package Bineks\coinmarketcap\Services
 */
class CoinMarketCap
{
    /** @var string */
    const SERVICE_URL = 'https://api.coinmarketcap.com/v2/';

    /** @var int */
    const CACHE_TIMEOUT = 5; //@TODO @FGT services config
    //@TODO @FGT cache prefix to config


    /**
     * Send request to CoinMarketCap.com
     *
     * @param string $method
     * @param string $url
     * @param array $query
     * @return null|mixed
     */
    public function doRequest(string $method, string $url, array $query = [])
    {
        return Cache::remember(
            $this->getCacheKey($method, $url, $query),
            Carbon::now()->addSeconds(self::CACHE_TIMEOUT),
            function() use($method, $url, $query) {
                $client = new \GuzzleHttp\Client([
                    'base_uri' => self::SERVICE_URL,
                    'protocols' => 'https'
                ]);

                $response = $client->request($method, $url, [
                    'http_errors' => false,
                    'query' => $query
                ]);

                if ($response->getStatusCode() == 200) {
                    return json_decode($response->getBody()->getContents(), true);
                }

                return null;
            });
    }


    /**
     * This method gets cryptocurrency ticker data in order of rank.
     * The maximum number of results per call is 100.
     * Pagination is possible by using the start and limit parameters.
     *
     * @param int $start
     * @param int $limit
     *
     * @return null|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTicker(int $start = 1, int $limit = 100): ?array
    {
        $response = $this->doRequest('GET', 'ticker', [
            'start' => $start,
            'limit' => $limit
        ]);

        return array_get($response, 'data');
    }


    /**
     * This  method gets cryptocurrency ticker data.
     *
     * @param int $id
     * @return null|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTickerById(int $id): ?array
    {
        $response = $this->doRequest('GET', "ticker/{$id}");

        return array_get($response, 'data');
    }


    /**
     * This methods gets cryptocurrency ticker data.
     * example "ETH"
     *
     * @param string $symbol
     * @return null|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTickerBySymbol(string $symbol): ?array
    {
        $listings = $this->getListings();
        if (!empty($listings)) {
            $item = collect($listings)->firstWhere('symbol', $symbol);

            if (!empty($item)) {
                $id = array_get($item, 'id');
                $response = $this->doRequest('GET', "ticker/{$id}");

                return array_get($response, 'data');
            }
        }

        return null;
    }


    /**
     * This methods gets all active cryptocurrency listings in one call.
     * Use the "id" field on the Ticker endpoint to query more information on a specific cryptocurrency.
     *
     * @return null|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getListings(): ?array
    {
        $response = $this->doRequest('GET', 'listings');

        return array_get($response, 'data');
    }


    /**
     * Generate Cache key
     *
     * @param string $method
     * @param string $url
     * @param array $query
     * @return string
     */
    protected function getCacheKey(string $method, string $url, array $query = []): string
    {
        $query = json_encode($query);
        return "coinmarkeycap:{$url}:{$method}:{$query}";
    }
}
