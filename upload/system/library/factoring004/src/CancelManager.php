<?php

declare(strict_types=1);

namespace BnplPartners\Factoring004Payment;

use BnplPartners\Factoring004\ChangeStatus\CancelOrder;
use BnplPartners\Factoring004\ChangeStatus\CancelStatus;
use BnplPartners\Factoring004\ChangeStatus\MerchantsOrders;
use BnplPartners\Factoring004\Exception\ErrorResponseException;
use BnplPartners\Factoring004\Response\ErrorResponse;
use Exception;

class CancelManager extends AbstractManager
{
    public function cancel(array $order): ManagerResponse
    {
        try {
            return $this->cancelOrder($order['order_id']);
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
        return $this->config->get('payment_factoring004_cancel_order_status_id');
    }

    /**
     * @param string|int $orderId
     *
     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function cancelOrder($orderId): ManagerResponse
    {
        $response = $this->api->changeStatus->changeStatusJson([
            new MerchantsOrders(
                $this->config->get('payment_factoring004_partner_code'),
                [
                    new CancelOrder($orderId, CancelStatus::CANCEL()),
                ],
            ),
        ]);

        foreach ($response->getErrorResponses() as $errorResponse) {
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
