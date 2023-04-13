<?php

namespace BnplPartners\Factoring004Payment;

use BnplPartners\Factoring004\Api;
use BnplPartners\Factoring004\Auth\BearerTokenAuth;
use BnplPartners\Factoring004\Transport\GuzzleTransport;
use BnplPartners\Factoring004\Transport\TransportInterface;
use Config;
use Log;
use Registry;

abstract class AbstractManager
{
    /**
     * @var \Config
     */
    protected $config;

    /**
     * @var \Log
     */
    protected $log;

    /**
     * @var \BnplPartners\Factoring004\Api
     */
    protected $api;

    /**
     * @var string[]
     */
    protected $confirmableDeliveries;

    public function __construct(Config $config, Log $log, Cache $cache)
    {
        $this->config = $config;
        $this->log = $log;
        $apiHost = $config->get('factoring004_api_host');
        $oauthLogin = $config->get('factoring004_oauth_login');
        $oauthPassword = $config->get('factoring004_oauth_password');
        $tokenManager = new \BnplPartners\Factoring004\OAuth\OAuthTokenManager($apiHost . '/users/api/v1', $oauthLogin, $oauthPassword);
        $tokenManager = new \BnplPartners\Factoring004\OAuth\CacheOAuthTokenManager($tokenManager, new BnplPartners\Factoring004Payment\CacheAdapter($cache), 'bnpl.payment');
        $this->api = Api::create(
            $apiHost,
            new BearerTokenAuth($tokenManager->getAccessToken()->getAccess()),
            $this->createTransport()
        );
        $this->confirmableDeliveries = $this->parseConfirmableDeliveries();
    }

    /**
     * @return static
     */
    public static function create(Registry $registry)
    {
        return new static($registry->get('config'), $registry->get('log'), $registry->get('cache'));
    }

    abstract public function getOrderStatusId();

    /**
     * @return string[]
     */
    protected function parseConfirmableDeliveries()
    {
        $raw = $this->config->get('factoring004_delivery');

        return $raw ? explode(',', $raw) : [];
    }

    /**
     * @param array<string, mixed> $order
     */
    protected function isOtpConfirmable(array $order)
    {
        $shippingCode = $this->parseShippingCode($order['shipping_code']);

        return in_array($shippingCode, $this->confirmableDeliveries);
    }

    protected function parseShippingCode(string $shippingCode)
    {
        return explode('.', $shippingCode, 2)[0];
    }

    protected function createTransport()
    {
        $factory = new DebugLoggerFactory($this->config);
        $transport = new GuzzleTransport();
        $transport->setLogger($factory->createLogger());

        return $transport;
    }
}
