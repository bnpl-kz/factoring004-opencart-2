<?php

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

    /**
     * @param bool $processed
     * @param bool $success
     * @param bool $sentOtp
     * @param string $message
     * @param bool $return
     */
    public function __construct($processed, $success, $sentOtp, $message, $return = false)
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
    public static function createFromArray(array $response)
    {
        return new self(
            $response['process'],
            $response['success'],
            $response['otp'],
            $response['message'],
            isset($response['return']) ? $response['return'] : false
        );
    }

    public static function createAsUnprocessed()
    {
        return new self(false, true, false, '');
    }

    public static function createReturnAsUnprocessed()
    {
        return new self(false, true, false, '', true);
    }

    public function isProcessed()
    {
        return $this->processed;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    public function isSentOtp()
    {
        return $this->sentOtp;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function isReturn()
    {
        return $this->return;
    }
}
