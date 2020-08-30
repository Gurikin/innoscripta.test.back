<?php


namespace App\Twig;


use App\Service\CurrencyExchange\CurrencyExchangeHttpService;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class TwigExtension
 * @package App\Twig
 */
class TwigExtension extends AbstractExtension
{
    /**
     * @var CurrencyExchangeHttpService
     */
    private CurrencyExchangeHttpService $currencyExchangeHttpService;

    /**
     * TwigExtension constructor.
     * @param CurrencyExchangeHttpService $currencyExchangeHttpService
     */
    public function __construct(CurrencyExchangeHttpService $currencyExchangeHttpService)
    {
        $this->currencyExchangeHttpService = $currencyExchangeHttpService;
    }

    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('price', function (float $price, string $toCurrency) {
                $rate = $this->currencyExchangeHttpService->getRate($toCurrency);
                return $price * (float)$rate;
            })
        ];
    }
}