<?php


namespace App\Service\CurrencyExchange;


interface CurrencyExchangeInterface
{
    /**
     * @param string $toCurrency
     * @return float
     */
    public function getRate(string $toCurrency): float;
}