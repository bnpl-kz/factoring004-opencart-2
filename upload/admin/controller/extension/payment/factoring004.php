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
            $this->request->post['factoring004_agreement_file'] = isset($this->request->files['factoring004_agreement_file']) ?
                $this->agreementFileUpload($this->request->files['factoring004_agreement_file'])
                : $this->request->post['factoring004_agreement_file'];
            $this->request->post['factoring004_delivery'] = isset($this->request->post['factoring004_delivery']) ?
                implode(',',$this->request->post['factoring004_delivery']) : '';
            $this->model_setting_setting->editSetting('factoring004', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        }

        if (($this->request->server['REQUEST_METHOD'] === 'DELETE')) {
            if (!$this->agreementFileDelete($this->request->get['filename'])) {
                echo json_encode(['success'=>false,'message'=>$this->language->get('error_agreement_file_delete')]);
            } else {
                $this->model_setting_setting->editSettingValue('factoring004', 'factoring004_agreement_file');
                echo json_encode(['success'=>true,'message'=>$this->language->get('success_agreement_file_delete')]);
            }
            return;
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

        if (isset($this->error['preapp_token'])) {
            $data['error_preapp_token'] = $this->error['preapp_token'];
        } else {
            $data['error_preapp_token'] = '';
        }

        if (isset($this->error['delivery_token'])) {
            $data['error_delivery_token'] = $this->error['delivery_token'];
        } else {
            $data['error_delivery_token'] = '';
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

        if (isset($this->request->post['factoring004_preapp_token'])) {
            $data['factoring004_preapp_token'] = $this->request->post['factoring004_preapp_token'];
        } else {
            $data['factoring004_preapp_token'] = $this->config->get('factoring004_preapp_token');
        }

        if (isset($this->request->post['factoring004_delivery_token'])) {
            $data['factoring004_delivery_token'] = $this->request->post['factoring004_delivery_token'];
        } else {
            $data['factoring004_delivery_token'] = $this->config->get('factoring004_delivery_token');
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

        if (isset($this->request->post['factoring004_partner_email'])) {
            $data['factoring004_partner_email'] = $this->request->post['factoring004_partner_email'];
        } else {
            $data['factoring004_partner_email'] = $this->config->get('factoring004_partner_email');
        }

        if (isset($this->request->post['factoring004_partner_website'])) {
            $data['factoring004_partner_website'] = $this->request->post['factoring004_partner_website'];
        } else {
            $data['factoring004_partner_website'] = $this->config->get('factoring004_partner_website');
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

        if (isset($this->request->post['factoring004_delivery_order_status_id'])) {
            $data['factoring004_delivery_order_status_id'] = $this->request->post['factoring004_delivery_order_status_id'];
        } else {
            $data['factoring004_delivery_order_status_id'] = $this->config->get('factoring004_delivery_order_status_id');
        }

        if (isset($this->request->post['factoring004_return_order_status_id'])) {
            $data['factoring004_return_order_status_id'] = $this->request->post['factoring004_return_order_status_id'];
        } else {
            $data['factoring004_return_order_status_id'] = $this->config->get('factoring004_return_order_status_id');
        }

        if (isset($this->request->post['factoring004_cancel_order_status_id'])) {
            $data['factoring004_cancel_order_status_id'] = $this->request->post['factoring004_cancel_order_status_id'];
        } else {
            $data['factoring004_cancel_order_status_id'] = $this->config->get('factoring004_cancel_order_status_id');
        }

        if (isset($this->request->post['factoring004_delivery'])) {
            $data['factoring004_delivery'] = explode(',',$this->request->post['factoring004_delivery']);
        } else {
            $data['factoring004_delivery'] = explode(',',$this->config->get('factoring004_delivery'));
        }

        if (isset($this->request->post['factoring004_agreement_file'])) {
            $data['factoring004_agreement_file'] = $this->request->post['factoring004_agreement_file'];
        } else {
            $data['factoring004_agreement_file'] = $this->config->get('factoring004_agreement_file');
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

        // подключение языка
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['entry_api_host'] = $this->language->get('entry_api_host');
        $data['entry_preapp_token'] = $this->language->get('entry_preapp_token');
        $data['entry_delivery_token'] = $this->language->get('entry_delivery_token');
        $data['entry_partner_name'] = $this->language->get('entry_partner_name');
        $data['entry_partner_code'] = $this->language->get('entry_partner_code');
        $data['entry_point_code'] = $this->language->get('entry_point_code');
        $data['entry_partner_email'] = $this->language->get('entry_partner_email');
        $data['entry_partner_website'] = $this->language->get('entry_partner_website');
        $data['entry_paid_order_status'] = $this->language->get('entry_paid_order_status');
        $data['entry_unpaid_order_status'] = $this->language->get('entry_unpaid_order_status');
        $data['entry_delivery_order_status'] = $this->language->get('entry_delivery_order_status');
        $data['entry_return_order_status'] = $this->language->get('entry_return_order_status');
        $data['entry_cancel_order_status'] = $this->language->get('entry_cancel_order_status');
        $data['entry_delivery_items'] = $this->language->get('entry_delivery_items');
        $data['entry_agreement_file'] = $this->language->get('entry_agreement_file');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['text_button_agreement_file'] = $this->language->get('text_button_agreement_file');
        $data['text_agreement_file'] = $this->language->get('text_agreement_file');
        $data['entry_debug_mode'] = $this->language->get('entry_debug_mode');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['text_loading'] = $this->language->get('text_loading');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $data['deliveries'] = $this->getDeliveryItems();
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
        $this->model_extension_factoring004->install();
    }

    /**
     * @throws \Exception
     */
    public function uninstall()
    {
        $this->load->model('extension/payment/factoring004');
        $this->model_extension_factoring004->uninstall();
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/factoring004')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['factoring004_api_host']) {
            $this->error['api_host'] = $this->language->get('error_api_host');
        }

        if (!$this->request->post['factoring004_preapp_token']) {
            $this->error['preapp_token'] = $this->language->get('error_preapp_token');
        }

        if (!$this->request->post['factoring004_delivery_token']) {
            $this->error['delivery_token'] = $this->language->get('error_delivery_token');
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

    private function getDeliveryItems()
    {
        $this->load->model('extension/extension');
        $extensions = $this->model_extension_extension->getInstalled('shipping');

        foreach ($extensions as $key => $value) {
            if (!is_file(DIR_APPLICATION . 'controller/extension/shipping/' . $value . '.php') && !is_file(DIR_APPLICATION . 'controller/shipping/' . $value . '.php')) {
                $this->model_setting_extension->uninstall('shipping', $value);
                unset($extensions[$key]);
            }
        }

        $deliveries = array();
        $files = glob(DIR_APPLICATION . 'controller/extension/shipping/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, '.php');
                $this->load->language('extension/shipping/' . $extension, 'extension');
                if ($this->config->get('shipping_' . $extension . '_status')) {
                    $deliveries[] = array(
                        'id'         => $extension,
                        'name'       => $this->language->get('extension')->get('heading_title')
                    );
                }
            }
        }
        return $deliveries;
    }

    private function agreementFileUpload($agreement)
    {
        $filename = '';
        if ($agreement['tmp_name']) {
            $ext = pathinfo($agreement['name'], PATHINFO_EXTENSION);
            $filename = basename($agreement['name'],'.'.$ext) . '_' . token(32) . '.' . $ext;
            move_uploaded_file($agreement['tmp_name'], DIR_IMAGE . $filename);
        }
        return $filename;
    }

    private function agreementFileDelete($filename)
    {
        if (file_exists(DIR_IMAGE . $filename)) {
            return unlink(DIR_IMAGE . $filename);
        }
        return true;
    }
}
