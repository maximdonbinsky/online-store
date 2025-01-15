<?php

namespace App\Servises;

use App\Classes\CurrencyConversion;
use Exception;
use GuzzleHttp\Client;


class CurrencyRates
{
    public static function getRates()
    {
        $baseCurrency = CurrencyConversion::getBaseCurrency();
        $url = config('currency_rates.api_url') . $baseCurrency->code;
        $client = new Client();
        $response = $client->request('GET', $url);
        if ($response->getStatusCode() !== 200) {
            throw new Exception('There is a problem with currency services');
        }
        $rates = json_decode($response->getBody()->getContents(), true)['conversion_rates'];

        foreach (CurrencyConversion::getCurrencies() as $currency) {
            if (!$currency->isMain()) {
                if (!isset($rates[$currency->code])) {
                    throw new Exception('There is a problem with' . $currency->code);
                }
                else {
                    $currency->update(['rate' => $rates[$currency->code]]);
                }
            }
        }

    }

}
