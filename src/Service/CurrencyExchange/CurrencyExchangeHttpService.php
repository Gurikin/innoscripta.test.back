<?php


namespace App\Service\CurrencyExchange;


use stdClass;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyExchangeHttpService implements CurrencyExchangeInterface
{
    private const EXCHANGE_API_URL = 'https://api.exchangeratesapi.io/latest';

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * TwigExtinsion constructor.
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    /**
     * @inheritDoc
     * @throws TransportExceptionInterface
     */
    public function getRate(string $toCurrency): float
    {
        $rates = $this->httpClient->request(
            'GET',
            self::EXCHANGE_API_URL
        );
        try {
            $ratesObject = json_decode($rates->getContent());
            return $ratesObject->rates->$toCurrency ? $ratesObject->rates->$toCurrency : 1.0;
        } catch (ClientExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        }
        return 1.0;
    }
}