<?php

declare(strict_types=1);

/**
 * @property-read \Loader $load
 * @property-read \ModelCheckoutOrder $model_checkout_order
 * @property-read \ModelExtensionPaymentFactoring004 $model_extension_payment_factoring004
 * @property-read \Config $config
 * @property-read \DB $db
 */

class ControllerExtensionPaymentFactoring004 extends Controller
{
    const REQUIRED_FIELDS = ['billNumber', 'status', 'preappId'];

    public function index()
    {
        $data['button_confirm'] = $this->language->get('button_confirm');

        $this->load->model('checkout/order');

        if (!isset($this->session->data['order_id'])) {
            return false;
        }

        if (($this->request->server['REQUEST_METHOD'] === 'POST')) {
            $this->createPreapp($this->model_checkout_order->getOrder($this->session->data['order_id']));
        }

        $data['action'] = $this->url->link('extension/payment/factoring004');

        return $this->load->view('extension/payment/factoring004', $data);

    }

    private function createPreapp($data)
    {
        print_r($data);die;
    }

    /**
     * @throws \Exception
     */
    public function postLink(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Allow: POST');
            $this->jsonResponse(['success' => false, 'error' => 'Method not allowed'], 405, 'Method Not Allowed');
            return;
        }

        $this->load->model('checkout/order');
        $this->load->model('extension/payment/factoring004');

        try {
            $request = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $this->jsonResponse(['success' => false, 'error' => 'Input data is invalid'], 400, 'Bad Request');
            return;
        }

        foreach (static::REQUIRED_FIELDS as $field) {
            if (empty($request[$field]) || !is_string($field)) {
                $this->jsonResponse(['success' => false, 'error' => $field . ' is invalid'], 400, 'Bad Request');
                return;
            }
        }

        $order = $this->model_checkout_order->getOrder($request['billNumber']);

        if (!$order) {
            $this->jsonResponse(['success' => false, 'error' => 'Order not found'], 400, 'Bad Request');
            return;
        }

        if ($request['status'] === 'preapproved') {
            $this->jsonResponse(['response' => 'preapproved']);
            return;
        }

        $comment = 'PreAppId: ' . $request['preappId'];

        if ($request['status'] === 'declined') {
            $response = 'declined';
            $orderStatusId = 10;
        } elseif ($request['status'] === 'completed') {
            $response = 'ok';
            $orderStatusId = 5;
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Unexpected status'], 400, 'Bad Request');
            return;
        }

        try {
            $this->db->query('BEGIN');
            $this->model_checkout_order->addOrderHistory($order['order_id'], $orderStatusId, $comment);
            $this->model_extension_payment_factoring004->add($order['order_id'], $request['preappId']);
            $this->db->query('COMMIT');
        } catch (Exception $e) {
            $this->db->query('ROLLBACK');
            $this->jsonResponse(['success' => false, 'error' => 'An error occurred'], 500, 'Internal Server Error');
            return;
        }

        $this->jsonResponse(compact('response'));
    }

    /**
     * @param array<string, mixed> $data
     */
    private function jsonResponse(array $data, int $status = 200, string $reasonPhrase = 'OK'): void
    {
        try {
            $json = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Invalid JSON', 0, $e);
        }

        header(sprintf('HTTP/1.1 %d %s', $status, $reasonPhrase));
        header('Content-Type: application/json');
        echo $json;
    }
}
