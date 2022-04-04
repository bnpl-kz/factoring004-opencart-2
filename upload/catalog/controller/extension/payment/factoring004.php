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
            $this->preapp($this->model_checkout_order->getOrder($this->session->data['order_id']));
            exit;
        }

        $data['action'] = $this->url->link('extension/payment/factoring004');

        return $this->load->view('extension/payment/factoring004', $data);

    }

    private function preapp($data)
    {
        header('Content-Type: application/json');
        try {
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 2);
            $products = $this->model_checkout_order->getOrderProducts($this->session->data['order_id']);
            require_once DIR_SYSTEM . 'library/factoring004/vendor/autoload.php';
            $response = \BnplPartners\Factoring004\Api::create(
                $this->config->get('payment_factoring004_api_host'),
                new \BnplPartners\Factoring004\Auth\BearerTokenAuth($this->config->get('payment_factoring004_preapp_token'))
            )->preApps->preApp(
                \BnplPartners\Factoring004\PreApp\PreAppMessage::createFromArray([
                    'partnerData' => [
                        'partnerName' => $this->config->get('payment_factoring004_partner_name'),
                        'partnerCode' => $this->config->get('payment_factoring004_partner_code'),
                        'pointCode' => $this->config->get('payment_factoring004_point_code'),
                        'partnerEmail' => $this->config->get('payment_factoring004_partner_email'),
                        'partnerWebsite' => $this->config->get('payment_factoring004_partner_website'),
                    ],
                    'billNumber' => (string)$data['order_id'],
                    'billAmount' => (int)ceil($data['total']),
                    'itemsQuantity' => array_sum(array_map(function ($item) {
                        return $item['quantity'];
                    }, $products)),
                    'items' => array_map(function ($item) {
                        return [
                            'itemId' => (string)$item['product_id'],
                            'itemName' => $item['name'] . '/' . $item['model'],
                            'itemCategory' => $item['name'],
                            'itemQuantity' => (int)$item['quantity'],
                            'itemPrice' => (int)ceil($item['price']),
                            'itemSum' => (int)ceil($item['total']),
                        ];
                    }, $products),
                    'successRedirect' => $this->url->link('checkout/success'),
                    'failRedirect' => $this->url->link('checkout/failure'),
                    'postLink' => $this->url->link('extension/payment/factoring004/postLink'),
                    'phoneNumber' => preg_replace('/^8|\+7/', '7', $data['telephone']),
                    'deliveryPoint' => [
                        'region' => $data['shipping_zone'],
                        'city' => $data['shipping_city'],
                        'street' => $data['shipping_address_1'] . ' ' . $data['shipping_address_2']
                    ]
                ])
            );
            $this->jsonResponse(['success' => true, 'redirectLink' => $response->getRedirectLink()]);
        }
        catch (\Exception $e) {
            $this->log->write('Factoring004: ' . $e);
            $this->jsonResponse(['success' => false, 'error' => 'An error occurred!']);
        }
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
            $orderStatusId = $this->config->get('payment_factoring004_unpaid_order_status_id');
        } elseif ($request['status'] === 'completed') {
            $response = 'ok';
            $orderStatusId = $this->config->get('payment_factoring004_paid_order_status_id');
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
