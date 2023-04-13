<?php

namespace BnplPartners\Factoring004Payment;

use Log;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class DebugLogger extends AbstractLogger
{
    /**
     * @var \Log
     */
    private $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function log($level, $message, array $context = [])
    {
        if ($level !== LogLevel::DEBUG) {
            return;
        }

        $this->log->write($message);
    }
}
