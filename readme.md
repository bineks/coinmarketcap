## Integration with CoinMarketCap.com API v2 for Laravel 5.5 and later

### Install

```sh
$ composer require "bineks/coinmarketcap"
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