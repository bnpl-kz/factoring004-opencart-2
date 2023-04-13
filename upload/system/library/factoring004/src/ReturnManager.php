<?php

namespace BnplPartners\Factoring004Payment;

use BnplPartners\Factoring004\ChangeStatus\MerchantsOrders;
use BnplPartners\Factoring004\ChangeStatus\ReturnOrder;
use BnplPartners\Factoring004\ChangeStatus\ReturnStatus;
use BnplPartners\Factoring004\Exception\ErrorResponseException;
use BnplPartners\Factoring004\Otp\CheckOtpReturn;
use BnplPartners\Factoring004\Otp\SendOtpReturn;
use BnplPartners\Factoring004\Response\ErrorResponse;
use Exception;

class ReturnManager extends AbstractManager
{
    /**
     * @param array<string, mixed> $order
     * @param array<string, mixed> $postData
     */
    public function makeReturn(array $order, array $postData)
    {
        $amountReturn = intval(isset($postData['factoring004_amount']) ? $postData['factoring004_amount'] : 0);
        $amountRemaining = $this->getAmountRemaining($order, $amountReturn);

        try {
            if (!empty($postData['factoring004_otp'])) {
                return $this->checkOtp($order['order_id'], $postData['factoring004_otp'], $amountRemaining);
            }

            if ($this->isOtpConfirmable($order)) {
                return $this->sendOtp($order['order_id'], $amountRemaining);
            }

            return $this->returnWithoutOtp($order['order_id'], $amountRemaining);
        } catch (ErrorResponseException $e) {
            return ManagerResponse::createFromArray([
                'process' => true,
                'success' => false,
                'otp' => false,
                'message' => $e->getErrorResponse()->getMessage(),
                'return' => false,
            ]);
        } catch (Exception $e) {
            $this->log->write('Factoring004: ' . $e);

            return ManagerResponse::createFromArray([
                'process' => true,
                'success' => false,
                'otp' => false,
                'message' => 'An error occurred',
                'return' => false,
            ]);
        }
    }

    public function getOrderStatusId()
    {
        return $this->config->get('factoring004_return_order_status_id');
    }

    /**
     * @param int|string $orderId
     * @param int $amountReturn
     * @param string $otp

     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function checkOtp($orderId, $otp, $amountReturn = 0)
    {
        $response = $this->api->otp->checkOtpReturn(new CheckOtpReturn(
            $amountReturn,
            $this->config->get('factoring004_partner_code'),
            $orderId,
            $otp
        ));

        return ManagerResponse::createFromArray([
            'process' => true,
            'otp' => false,
            'success' => true,
            'message' => $response->getMsg(),
            'return' => true,
        ]);
    }

    /**
     * @param int|string $orderId
     * @param int $amountRemaining

     * @throws \BnplPartners\Factoring004\Exception\PackageException
     */
    private function sendOtp($orderId, $amountRemaining = 0)
    {
        $response = $this->api->otp->sendOtpReturn(new SendOtpReturn(
            $amountRemaining,
            $this->config->get('factoring004_partner_code'),
            $orderId
        ));

        return ManagerResponse::createFromArray([
            'process' => true,
            'otp' => true,
            'success' => true,
            'message' => $response->getMsg(),
            'return' => true,
        ]);
    }

    /**
     * @param int|string $orderId
     * @param int $amountRemaining
     */
    private function returnWithoutOtp($orderId, $amountRemaining = 0)
    {
        $status = $amountRemaining > 0 ? ReturnStatus::PARTRETURN() : ReturnStatus::RETURN();

        $changeStatusResponse = $this->api->changeStatus->changeStatusJson([
            new MerchantsOrders(
                $this->config->get('factoring004_partner_code'),
                [
                    new ReturnOrder($orderId, $status, $amountRemaining),
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
            'return' => true,
        ]);
    }

    /**
     * @param array<string, mixed> $order
     * @param int $amountReturn
     */
    private function getAmountRemaining(array $order, $amountReturn = 0)
    {
        return ($amountReturn > 0 && $order['total'] > $amountReturn)
            ? (int) ceil($order['total']) - $amountReturn
            : 0;
    }
}
