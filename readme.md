[![Travis](https://img.shields.io/travis/bineks/coinmarketcap.svg?maxAge=2592000?style=flat-square)](https://travis-ci.org/bineks/coinmarketcap)
[![Packagist](https://img.shields.io/packagist/l/bineks/coinmarketcap.svg?maxAge=2592000?style=flat-square)](https://packagist.org/packages/bineks/coinmarketcap)
[![Packagist](https://img.shields.io/packagist/v/bineks/coinmarketcap.svg?maxAge=2592000?style=flat-square)](https://packagist.org/packages/bineks/coinmarketcap)
[![StyleCI](https://styleci.io/repos/160199198/shield)](https://styleci.io/repos/160199198)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/bineks/coinmarketcap.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/bineks/coinmarketcap/)

## Integration with CoinMarketCap.com API v2 for Laravel 5.5 and later

### Install

```sh
$ composer require "bineks/coinmarketcap"
```

### Config (optional) file 'config/services.php' 
```sh
[
  'coinmarketcap' => [
    'cache' => [
      'timeout' => 5, //seconds by default
      'prefix'  => 'coinmarkeycap' //default
    ]
  ]
]
```

### Using

```sh
use Bineks\Coinmarketcap\Services\CoinMarketCap;
use Illuminate\Routing\Controller

class Controller extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * @param CoinMarketCap $coinMarketCap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(CoinMarketCap $coinMarketCap) {

       //Get all active cryptocurrency listings in one call.
       $coinMarketCap->getListings();
       
       //Get cryptocurrency ticker data in order of rank.
       $coinMarketCap->getTicker();
       
       //Get cryptocurrency ticker data. `Id` from "getListings" method.
       $coinMarketCap->getTickerById(1);
       
       //Get cryptocurrency ticker data.
       $coinMarketCap->getTickerBySymbol('ETH');
    }
}
```
