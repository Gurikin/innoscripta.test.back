<?php


namespace App\Service\CurrencyExchange;


use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyExchangeHttpService implements CurrencyExchangeInterface
{
    private const EXCHANGE_API_URL = 'https://api.exchangeratesapi.io/latest';
    private const CURRENCY_EXCHANGE_PREFIX = 'currency.exchange';
    private const CURRENCY_RATE_REFRESH_TIME = 24*60*60;

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;
    /** @var FilesystemAdapter $cache */
    private $cache;


    /**
     * TwigExtinsion constructor.
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->cache = new FilesystemAdapter();
    }


    /**
     * @inheritDoc
     * @throws TransportExceptionInterface
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getRate(string $toCurrency): float
    {
        /** @var CacheItem $rate */
        $rate = $this->cache->getItem(self::CURRENCY_EXCHANGE_PREFIX . '.' . $toCurrency);
        if ($rate->get()) {
            return $rate->get();
        }
        $rates = $this->httpClient->request(
            'GET',
            self::EXCHANGE_API_URL
        );
        try {
            $ratesObject = json_decode($rates->getContent());
            $rate->set($ratesObject->rates->$toCurrency ? $ratesObject->rates->$toCurrency : 1.0);
            $rate->expiresAfter(self::CURRENCY_RATE_REFRESH_TIME);
            $this->cache->save($rate);
            return $rate->get();
        } catch (ClientExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        }
        return 1.0;
    }
}