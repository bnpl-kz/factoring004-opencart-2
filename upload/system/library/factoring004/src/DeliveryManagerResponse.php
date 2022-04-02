<?php

declare(strict_types=1);

namespace BnplPartners\Factoring004Payment;

class DeliveryManagerResponse
{
    /**
     * @var bool
     */
    private $processed;

    /**
     * @var bool
     */
    private $success;

    /**
     * @var bool
     */
    private $sentOtp;

    /**
     * @var string
     */
    private $message;

    public function __construct(bool $processed, bool $success, bool $sentOtp, string $message)
    {
        $this->processed = $processed;
        $this->success = $success;
        $this->sentOtp = $sentOtp;
        $this->message = $message;
    }

    /**
     * @param array<string, mixed> $response
     */
    public static function createFromArray(array $response): DeliveryManagerResponse
    {
        return new self(
            $response['process'],
            $response['success'],
            $response['otp'],
            $response['message'],
        );
    }

    public static function createAsUnprocessed(): DeliveryManagerResponse
    {
        return new self(false, true, false, '');
    }

    public function isProcessed(): bool
    {
        return $this->processed;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function isSentOtp(): bool
    {
        return $this->sentOtp;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
