<?php

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
    public function delivery(array $order, array $postData)
    {
        try {
            if (!empty($postData['factoring004_otp'])) {
                return $this->checkOtp(
                    $order['order_id'],
                    $postData['factoring004_otp'],
                    intval(
                        ceil($order['total'])
                    )
                );
            }

            if ($this->isOtpConfirmable($order)) {
                return $this->sendOtp(
                    $order['order_id'],
                    intval(
                        ceil($order['total'])
                    )
                );
            }

            return $this->deliveryWithoutOtp(
                $order['order_id'],
                intval(
                    ceil($order['total'])
                )
            );
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

    public function getOrderStatusId()
    {
        return $this->config->get('factoring004_delivery_order_status_id');
    }

    /**
     * @param int|string $orderId
     *
     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function checkOtp($orderId, string $otp, int $orderTotal)
    {
        $response = $this->api->otp->checkOtp(new CheckOtp(
            $this->config->get('factoring004_partner_code'),
            $orderId,
            $otp,
            $orderTotal
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
    private function sendOtp($orderId, int $orderTotal)
    {
        $response = $this->api->otp->sendOtp(new SendOtp(
            $this->config->get('factoring004_partner_code'),
            $orderId,
            $orderTotal
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
    private function deliveryWithoutOtp($orderId, int $orderTotal)
    {
        $changeStatusResponse = $this->api->changeStatus->changeStatusJson([
            new MerchantsOrders(
                $this->config->get('factoring004_partner_code'),
                [
                    new DeliveryOrder(
                        $orderId,
                        DeliveryStatus::DELIVERED(),
                        $orderTotal
                    ),
                ]
            ),
        ]);

        foreach ($changeStatusResponse->getErrorResponses() as $errorResponse) {
            throw new ErrorResponseException(new ErrorResponse(
                $errorResponse->getCode(),
                $errorResponse->getMessage(),
                null,
                null,
                $errorResponse->getError()
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
