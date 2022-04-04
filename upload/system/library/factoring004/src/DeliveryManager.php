<?php

declare(strict_types=1);

namespace BnplPartners\Factoring004Payment;

use BnplPartners\Factoring004\ChangeStatus\DeliveryOrder;
use BnplPartners\Factoring004\ChangeStatus\DeliveryStatus;
use BnplPartners\Factoring004\ChangeStatus\MerchantsOrders;
use BnplPartners\Factoring004\Exception\ErrorResponseException;
use BnplPartners\Factoring004\Otp\CheckOtp;
use BnplPartners\Factoring004\Otp\SendOtp;
use BnplPartners\Factoring004\Response\ErrorResponse;
use Exception;

class DeliveryManager extends AbstractManager
{
    /**
     * @param array<string, mixed> $order
     * @param array<string, mixed> $postData
     */
    public function delivery(array $order, array $postData): ManagerResponse
    {
        try {
            if (!empty($postData['factoring004_otp'])) {
                return $this->checkOtp($order['order_id'], $postData['factoring004_otp']);
            }

            if ($this->isOtpConfirmable($order)) {
                return $this->sendOtp($order['order_id']);
            }

            return $this->deliveryWithoutOtp($order['order_id']);
        } catch (ErrorResponseException $e) {
            return ManagerResponse::createFromArray([
                'process' => true,
                'success' => false,
                'otp' => false,
                'message' => $e->getErrorResponse()->getMessage(),
            ]);
        } catch (Exception $e) {
            $this->log->write('Factoring004: ' . $e);

            return ManagerResponse::createFromArray([
                'process' => true,
                'success' => false,
                'otp' => false,
                'message' => 'An error occurred',
            ]);
        }
    }

    public function getOrderStatusId(): string
    {
        return $this->config->get('payment_factoring004_delivery_order_status_id');
    }

    /**
     * @param int|string $orderId
     *
     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function checkOtp($orderId, string $otp): ManagerResponse
    {
        $response = $this->api->otp->checkOtp(new CheckOtp(
            $this->config->get('payment_factoring004_partner_code'),
            $orderId,
            $otp,
        ));

        return ManagerResponse::createFromArray([
            'process' => true,
            'otp' => false,
            'success' => true,
            'message' => $response->getMsg(),
        ]);
    }

    /**
     * @param int|string $orderId
     *
     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function sendOtp($orderId): ManagerResponse
    {
        $response = $this->api->otp->sendOtp(new SendOtp(
            $this->config->get('payment_factoring004_partner_code'),
            $orderId
        ));

        return ManagerResponse::createFromArray([
            'process' => true,
            'otp' => true,
            'success' => true,
            'message' => $response->getMsg(),
        ]);
    }

    /**
     * @param int|string $orderId
     *
     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function deliveryWithoutOtp($orderId): ManagerResponse
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

        return ManagerResponse::createFromArray([
            'process' => true,
            'otp' => false,
            'success' => true,
            'message' => 'OK',
        ]);
    }
}
