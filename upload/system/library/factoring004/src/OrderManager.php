<?php

declare(strict_types=1);

namespace BnplPartners\Factoring004Payment;

use Registry;

class OrderManager
{
    /**
     * @var \BnplPartners\Factoring004Payment\DeliveryManager
     */
    private $deliveryManager;

    /**
     * @var \BnplPartners\Factoring004Payment\ReturnManager
     */
    private $returnManager;

    public function __construct(DeliveryManager $deliveryManager, ReturnManager $returnManager)
    {
        $this->deliveryManager = $deliveryManager;
        $this->returnManager = $returnManager;
    }

    public static function create(Registry $registry): OrderManager
    {
        return new self(DeliveryManager::create($registry), ReturnManager::create($registry));
    }

    /**
     * @param array<string, mixed> $order
     * @param array<string, mixed> $postData
     */
    public function handle(array $order, array $postData): ManagerResponse
    {
        if ($order['payment_code'] !== 'factoring004') {
            return ManagerResponse::createAsUnprocessed();
        }

        if (empty($postData['order_status_id'])) {
            return ManagerResponse::createAsUnprocessed();
        }

        if ($postData['order_status_id'] === $this->deliveryManager->getOrderStatusId()) {
            return $this->deliveryManager->delivery($order, $postData);
        }

        if ($postData['order_status_id'] === $this->returnManager->getOrderStatusId()) {
            return $this->returnManager->return($order, $postData);
        }

        return ManagerResponse::createAsUnprocessed();
    }
}
