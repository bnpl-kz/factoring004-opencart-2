<?php

namespace BnplPartners\Factoring004Payment;

use Config;
use Registry;

class ModalWidgetUrlResolver
{
    const BNPL_HOST = 'bnpl.kz';
    const DEV_WIDGET_HOST = 'https://dev.bnpl.kz';
    const DEV_WIDGET_PATH = '/widget/index_bundle.js';
    const SECURE_SCHEME = 'https://';

    /**
     * @var \Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public static function create(Registry $registry)
    {
        return new static($registry->get('config'));
    }

    public function resolve()
    {
        $apiHost = $this->config->get('payment_factoring004_api_host');

        if (!$apiHost) {
            return static::DEV_WIDGET_HOST . static::DEV_WIDGET_PATH;
        }

        $host = parse_url($apiHost, PHP_URL_HOST);

        if (strrpos($host, static::BNPL_HOST) === false) {
            return static::DEV_WIDGET_HOST . static::DEV_WIDGET_PATH;
        }

        return static::SECURE_SCHEME . $host . static::DEV_WIDGET_PATH;
    }
}