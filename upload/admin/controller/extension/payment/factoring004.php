<?php

/**
 * @property-read \Loader $load
 * @property-read \ModelExtensionPaymentFactoring004 $model_extension_factoring004
 */
class ControllerExtensionPaymentFactoring004 extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/factoring004');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');
        $this->load->model('extension/payment/factoring004');
        $this->load->model('localisation/order_status');

        if (($this->request->server['REQUEST_METHOD'] === 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('factoring004', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extensions'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/factoring004', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/factoring004', 'token=' . $this->session->data['token'], true);
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

        $data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['api_host'])) {
            $data['error_api_host'] = $this->error['api_host'];
        } else {
            $data['error_api_host'] = '';
        }

        if (isset($this->error['oauth_login'])) {
            $data['error_oauth_login'] = $this->error['oauth_login'];
        } else {
            $data['error_oauth_login'] = '';
        }

        if (isset($this->error['oauth_password'])) {
            $data['error_oauth_password'] = $this->error['oauth_password'];
        } else {
            $data['error_oauth_password'] = '';
        }

        if (isset($this->error['partner_name'])) {
            $data['error_partner_name'] = $this->error['partner_name'];
        } else {
            $data['error_partner_name'] = '';
        }

        if (isset($this->error['partner_code'])) {
            $data['error_partner_code'] = $this->error['partner_code'];
        } else {
            $data['error_partner_code'] = '';
        }

        if (isset($this->error['point_code'])) {
            $data['error_point_code'] = $this->error['point_code'];
        } else {
            $data['error_point_code'] = '';
        }

        if (isset($this->request->post['factoring004_api_host'])) {
            $data['factoring004_api_host'] = $this->request->post['factoring004_api_host'];
        } else {
            $data['factoring004_api_host'] = $this->config->get('factoring004_api_host');
        }

        if (isset($this->request->post['factoring004_oauth_login'])) {
            $data['factoring004_oauth_login'] = $this->request->post['factoring004_oauth_login'];
        } else {
            $data['factoring004_oauth_login'] = $this->config->get('factoring004_oauth_login');
        }

        if (isset($this->request->post['factoring004_oauth_password'])) {
            $data['factoring004_oauth_password'] = $this->request->post['factoring004_oauth_password'];
        } else {
            $data['factoring004_oauth_password'] = $this->config->get('factoring004_oauth_password');
        }

        if (isset($this->request->post['factoring004_partner_name'])) {
            $data['factoring004_partner_name'] = $this->request->post['factoring004_partner_name'];
        } else {
            $data['factoring004_partner_name'] = $this->config->get('factoring004_partner_name');
        }

        if (isset($this->request->post['factoring004_partner_code'])) {
            $data['factoring004_partner_code'] = $this->request->post['factoring004_partner_code'];
        } else {
            $data['factoring004_partner_code'] = $this->config->get('factoring004_partner_code');
        }

        if (isset($this->request->post['factoring004_point_code'])) {
            $data['factoring004_point_code'] = $this->request->post['factoring004_point_code'];
        } else {
            $data['factoring004_point_code'] = $this->config->get('factoring004_point_code');
        }

        if (isset($this->request->post['factoring004_paid_order_status_id'])) {
            $data['factoring004_paid_order_status_id'] = $this->request->post['factoring004_paid_order_status_id'];
        } else {
            $data['factoring004_paid_order_status_id'] = $this->config->get('factoring004_paid_order_status_id');
        }

        if (isset($this->request->post['factoring004_unpaid_order_status_id'])) {
            $data['factoring004_unpaid_order_status_id'] = $this->request->post['factoring004_unpaid_order_status_id'];
        } else {
            $data['factoring004_unpaid_order_status_id'] = $this->config->get('factoring004_unpaid_order_status_id');
        }

        if (isset($this->request->post['factoring004_debug_mode'])) {
            $data['factoring004_debug_mode'] = $this->request->post['factoring004_debug_mode'];
        } else {
            $data['factoring004_debug_mode'] = $this->config->get('factoring004_debug_mode');
        }

        if (isset($this->request->post['factoring004_status'])) {
            $data['factoring004_status'] = $this->request->post['factoring004_status'];
        } else {
            $data['factoring004_status'] = $this->config->get('factoring004_status');
        }

        if (isset($this->request->post['factoring004_payment_gateway_type'])) {
            $data['factoring004_payment_gateway_type'] = $this->request->post['factoring004_payment_gateway_type'];
        } else {
            $data['factoring004_payment_gateway_type'] = $this->config->get('factoring004_payment_gateway_type');
        }

        // подключение языка
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['entry_api_host'] = $this->language->get('entry_api_host');
        $data['entry_oauth_login'] = $this->language->get('entry_oauth_login');
        $data['entry_oauth_password'] = $this->language->get('entry_oauth_password');
        $data['entry_partner_name'] = $this->language->get('entry_partner_name');
        $data['entry_partner_code'] = $this->language->get('entry_partner_code');
        $data['entry_point_code'] = $this->language->get('entry_point_code');
        $data['entry_paid_order_status'] = $this->language->get('entry_paid_order_status');
        $data['entry_unpaid_order_status'] = $this->language->get('entry_unpaid_order_status');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['entry_debug_mode'] = $this->language->get('entry_debug_mode');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['entry_payment_gateway_type'] = $this->language->get('entry_payment_gateway_type');
        $data['text_payment_gateway_type_redirect'] = $this->language->get('text_payment_gateway_type_redirect');
        $data['text_payment_gateway_type_modal'] = $this->language->get('text_payment_gateway_type_modal');

        $data['text_loading'] = $this->language->get('text_loading');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/factoring004', $data));
    }

    /**
     * @throws \Exception
     */
    public function install()
    {
        $this->load->model('extension/payment/factoring004');
        $this->model_extension_payment_factoring004->install();
    }

    /**
     * @throws \Exception
     */
    public function uninstall()
    {
        $this->load->model('extension/payment/factoring004');
        $this->model_extension_payment_factoring004->uninstall();
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/factoring004')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['factoring004_api_host']) {
            $this->error['api_host'] = $this->language->get('error_api_host');
        }

        if (!$this->request->post['factoring004_oauth_login']) {
            $this->error['oauth_login'] = $this->language->get('error_oauth_login');
        }

        if (!$this->request->post['factoring004_oauth_password']) {
            $this->error['oauth_password'] = $this->language->get('error_oauth_password');
        }

        if (!$this->request->post['factoring004_partner_name']) {
            $this->error['partner_name'] = $this->language->get('error_partner_name');
        }

        if (!$this->request->post['factoring004_partner_code']) {
            $this->error['partner_code'] = $this->language->get('error_partner_code');
        }

        if (!$this->request->post['factoring004_point_code']) {
            $this->error['point_code'] = $this->language->get('error_point_code');
        }

        return !$this->error;
    }
}
