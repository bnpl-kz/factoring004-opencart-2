<?php

declare(strict_types=1);

namespace BnplPartners\Factoring004Payment;

use BnplPartners\Factoring004\Api;
use BnplPartners\Factoring004\Auth\BearerTokenAuth;
use BnplPartners\Factoring004\ChangeStatus\DeliveryOrder;
use BnplPartners\Factoring004\ChangeStatus\DeliveryStatus;
use BnplPartners\Factoring004\ChangeStatus\MerchantsOrders;
use BnplPartners\Factoring004\Exception\ErrorResponseException;
use BnplPartners\Factoring004\Otp\CheckOtp;
use BnplPartners\Factoring004\Otp\SendOtp;
use BnplPartners\Factoring004\Response\ErrorResponse;
use Config;
use Exception;
use Log;
use Registry;

class DeliveryManager
{
    /**
     * @var \Config
     */
    private $config;

    /**
     * @var \Log
     */
    private $log;

    /**
     * @var \BnplPartners\Factoring004\Api
     */
    private $api;

    /**
     * @var string[]
     */
    private $confirmableDeliveries;

    public function __construct(Config $config, Log $log)
    {
        $this->config = $config;
        $this->log = $log;
        $this->api = Api::create(
            $config->get('payment_factoring004_api_host'),
            new BearerTokenAuth($config->get('payment_factoring004_delivery_token')),
        );
        $this->confirmableDeliveries = $this->parseConfirmableDeliveries();
    }

    public static function create(Registry $registry): DeliveryManager
    {
        return new self($registry->get('config'), $registry->get('log'));
    }

    /**
     * @param array<string, mixed> $order
     * @param array<string, mixed> $postData
     */
    public function delivery(array $order, array $postData): DeliveryManagerResponse
    {
        if ($order['payment_code'] !== 'factoring004') {
            return DeliveryManagerResponse::createAsUnprocessed();
        }

        if (empty($postData['order_status_id']) || $postData['order_status_id'] !== '3') {
            return DeliveryManagerResponse::createAsUnprocessed();
        }

        try {
            if (!empty($postData['factoring004_otp'])) {
                return $this->checkOtp($order['order_id'], $postData['factoring004_otp']);
            }

            $shippingCode = explode('.', $order['shipping_code'], 2)[0];

            if (in_array($shippingCode, $this->confirmableDeliveries)) {
                return $this->sendOtp($order['order_id']);
            }

            return $this->deliveryWithoutOtp($order['order_id']);
        } catch (ErrorResponseException $e) {
            return DeliveryManagerResponse::createFromArray([
                'process' => true,
                'success' => false,
                'otp' => false,
                'message' => $e->getErrorResponse()->getMessage(),
            ]);
        } catch (Exception $e) {
            $this->log->write('Factoring004: ' . $e);

            return DeliveryManagerResponse::createFromArray([
                'process' => true,
                'success' => false,
                'otp' => false,
                'message' => 'An error occurred',
            ]);
        }
    }

    /**
     * @return string[]
     */
    private function parseConfirmableDeliveries(): array
    {
        $raw = $this->config->get('payment_factoring004_delivery');

        return $raw ? explode(',', $raw) : [];
    }

    /**
     * @param int|string $orderId
     *
     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function checkOtp($orderId, string $otp): DeliveryManagerResponse
    {
        $response = $this->api->otp->checkOtp(new CheckOtp(
            $this->config->get('payment_factoring004_partner_code'),
            $orderId,
            $otp,
        ));

        return DeliveryManagerResponse::createFromArray([
            'process' => true,
            'otp' => false,
            'success' => true,
            'message' => '$response->getMsg()',
        ]);
    }

    /**
     * @param int|string $orderId
     *
     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function sendOtp($orderId): DeliveryManagerResponse
    {
        $response = $this->api->otp->sendOtp(new SendOtp(
            $this->config->get('payment_factoring004_partner_code'),
            $orderId
        ));

        return DeliveryManagerResponse::createFromArray([
            'process' => true,
            'otp' => true,
            'success' => true,
            'message' => '$response->getMsg()',
        ]);
    }

    /**
     * @param int|string $orderId
     *
     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function deliveryWithoutOtp($orderId): DeliveryManagerResponse
    {
        $changeStatusResponse = $this->api->changeStatus->changeStatusJson([
            new MerchantsOrders(
                $this->config->get('payment_factoring004_partner_code'),
                [
                    new DeliveryOrder($orderId, DeliveryStatus::DELIVERED()),
                ],
            ),
        ]);

        foreach ($changeStatusResponse->getErrorResponses() as $errorResponse) {
            throw new ErrorResponseException(new ErrorResponse(
                $errorResponse->getCode(),
                $errorResponse->getMessage(),
                null,
                null,
                $errorResponse->getError(),
            ));
        }

        return DeliveryManagerResponse::createFromArray([
            'process' => true,
            'otp' => false,
            'success' => true,
            'message' => 'OK',
        ]);
    }
}
