<?php

namespace BnplPartners\Factoring004Payment;

use Config;
use Log;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Registry;

class DebugLoggerFactory
{
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

    public function createLogger()
    {
        if ($this->isEnabled()) {
            return new DebugLogger(new Log($this->getLogFilename()));
        }

        return new NullLogger();
    }

    private function isEnabled()
    {
        return (bool) $this->config->get('factoring004_debug_mode');
    }

    private function getLogFilename()
    {
        return 'factoring004-' . date('Y-m-d') . '.log';
    }
}
