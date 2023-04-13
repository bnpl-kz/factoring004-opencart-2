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

    public function __construct(Config $config, Log $log)
    {
        $this->config = $config;
        $this->log = $log;
        $this->api = Api::create(
            $config->get('factoring004_api_host'),
            new BearerTokenAuth($config->get('factoring004_delivery_token')),
            $this->createTransport()
        );
        $this->confirmableDeliveries = $this->parseConfirmableDeliveries();
    }

    /**
     * @return static
     */
    public static function create(Registry $registry)
    {
        return new static($registry->get('config'), $registry->get('log'));
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
