<?php

declare(strict_types=1);

namespace BnplPartners\Factoring004Payment;

class ManagerResponse
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

    /**
     * @var bool
     */
    private $return;

    public function __construct(bool $processed, bool $success, bool $sentOtp, string $message, bool $return = false)
    {
        $this->processed = $processed;
        $this->success = $success;
        $this->sentOtp = $sentOtp;
        $this->message = $message;
        $this->return = $return;
    }

    /**
     * @param array<string, mixed> $response
     */
    public static function createFromArray(array $response): ManagerResponse
    {
        return new self(
            $response['process'],
            $response['success'],
            $response['otp'],
            $response['message'],
            $response['return'] ?? false,
        );
    }

    public static function createAsUnprocessed(): ManagerResponse
    {
        return new self(false, true, false, '');
    }

    public static function createReturnAsUnprocessed(): ManagerResponse
    {
        return new self(false, true, false, '', true);
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

    public function isReturn(): bool
    {
        return $this->return;
    }
}
