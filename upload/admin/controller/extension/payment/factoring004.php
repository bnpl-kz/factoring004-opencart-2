<?php

/**
 * @property-read \Loader $load
 * @property-read \ModelExtensionPaymentFactoring004 $model_extension_payment_factoring004
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
            $this->request->post['payment_factoring004_agreement_file'] = $this->agreementFileUpload($this->request->files['payment_factoring004_agreement_file']);
            $this->request->post['payment_factoring004_delivery'] = implode(',',$this->request->post['payment_factoring004_delivery']);
            $this->model_setting_setting->editSetting('payment_factoring004', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }

        if (($this->request->server['REQUEST_METHOD'] === 'DELETE')) {
            if (!$this->agreementFileDelete($this->request->get['filename'])) {
                echo json_encode(['success'=>false,'message'=>$this->language->get('error_agreement_file_delete')]);
            } else {
                $this->model_setting_setting->editSettingValue('payment_factoring004', 'payment_factoring004_agreement_file');
                echo json_encode(['success'=>true,'message'=>$this->language->get('success_agreement_file_delete')]);
            }
            return;
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extensions'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/factoring004', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/factoring004', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        $data['user_token'] = $this->session->data['user_token'];

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

        if (isset($this->error['partner_email'])) {
            $data['error_partner_email'] = $this->error['partner_email'];
        } else {
            $data['error_partner_email'] = '';
        }

        if (isset($this->error['partner_website'])) {
            $data['error_partner_website'] = $this->error['partner_website'];
        } else {
            $data['error_partner_website'] = '';
        }


        if (isset($this->request->post['payment_factoring004_api_host'])) {
            $data['payment_factoring004_api_host'] = $this->request->post['payment_factoring004_api_host'];
        } else {
            $data['payment_factoring004_api_host'] = $this->config->get('payment_factoring004_api_host');
        }

        if (isset($this->request->post['payment_factoring004_preapp_token'])) {
            $data['payment_factoring004_preapp_token'] = $this->request->post['payment_factoring004_preapp_token'];
        } else {
            $data['payment_factoring004_preapp_token'] = $this->config->get('payment_factoring004_preapp_token');
        }

        if (isset($this->request->post['payment_factoring004_delivery_token'])) {
            $data['payment_factoring004_delivery_token'] = $this->request->post['payment_factoring004_delivery_token'];
        } else {
            $data['payment_factoring004_delivery_token'] = $this->config->get('payment_factoring004_delivery_token');
        }

        if (isset($this->request->post['payment_factoring004_partner_name'])) {
            $data['payment_factoring004_partner_name'] = $this->request->post['payment_factoring004_partner_name'];
        } else {
            $data['payment_factoring004_partner_name'] = $this->config->get('payment_factoring004_partner_name');
        }

        if (isset($this->request->post['payment_factoring004_partner_code'])) {
            $data['payment_factoring004_partner_code'] = $this->request->post['payment_factoring004_partner_code'];
        } else {
            $data['payment_factoring004_partner_code'] = $this->config->get('payment_factoring004_partner_code');
        }

        if (isset($this->request->post['payment_factoring004_point_code'])) {
            $data['payment_factoring004_point_code'] = $this->request->post['payment_factoring004_point_code'];
        } else {
            $data['payment_factoring004_point_code'] = $this->config->get('payment_factoring004_point_code');
        }

        if (isset($this->request->post['payment_factoring004_partner_email'])) {
            $data['payment_factoring004_partner_email'] = $this->request->post['payment_factoring004_partner_email'];
        } else {
            $data['payment_factoring004_partner_email'] = $this->config->get('payment_factoring004_partner_email');
        }

        if (isset($this->request->post['payment_factoring004_partner_website'])) {
            $data['payment_factoring004_partner_website'] = $this->request->post['payment_factoring004_partner_website'];
        } else {
            $data['payment_factoring004_partner_website'] = $this->config->get('payment_factoring004_partner_website');
        }

        if (isset($this->request->post['payment_factoring004_paid_order_status_id'])) {
            $data['payment_factoring004_paid_order_status_id'] = $this->request->post['payment_factoring004_paid_order_status_id'];
        } else {
            $data['payment_factoring004_paid_order_status_id'] = $this->config->get('payment_factoring004_paid_order_status_id');
        }

        if (isset($this->request->post['payment_factoring004_unpaid_order_status_id'])) {
            $data['payment_factoring004_unpaid_order_status_id'] = $this->request->post['payment_factoring004_unpaid_order_status_id'];
        } else {
            $data['payment_factoring004_unpaid_order_status_id'] = $this->config->get('payment_factoring004_unpaid_order_status_id');
        }

        if (isset($this->request->post['payment_factoring004_delivery_order_status_id'])) {
            $data['payment_factoring004_delivery_order_status_id'] = $this->request->post['payment_factoring004_delivery_order_status_id'];
        } else {
            $data['payment_factoring004_delivery_order_status_id'] = $this->config->get('payment_factoring004_delivery_order_status_id');
        }

        if (isset($this->request->post['payment_factoring004_return_order_status_id'])) {
            $data['payment_factoring004_return_order_status_id'] = $this->request->post['payment_factoring004_return_order_status_id'];
        } else {
            $data['payment_factoring004_return_order_status_id'] = $this->config->get('payment_factoring004_return_order_status_id');
        }

        if (isset($this->request->post['payment_factoring004_delivery'])) {
            $data['payment_factoring004_delivery'] = explode(',',$this->request->post['payment_factoring004_delivery']);
        } else {
            $data['payment_factoring004_delivery'] = explode(',',$this->config->get('payment_factoring004_delivery'));
        }

        if (isset($this->request->post['payment_factoring004_agreement_file'])) {
            $data['payment_factoring004_agreement_file'] = $this->request->post['payment_factoring004_agreement_file'];
        } else {
            $data['payment_factoring004_agreement_file'] = $this->config->get('payment_factoring004_agreement_file');
        }

        if (isset($this->request->post['payment_factoring004_status'])) {
            $data['payment_factoring004_status'] = $this->request->post['payment_factoring004_status'];
        } else {
            $data['payment_factoring004_status'] = $this->config->get('payment_factoring004_status');
        }

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

        if (!$this->request->post['payment_factoring004_api_host']) {
            $this->error['api_host'] = $this->language->get('error_api_host');
        }

        if (!$this->request->post['payment_factoring004_preapp_token']) {
            $this->error['preapp_token'] = $this->language->get('error_preapp_token');
        }

        if (!$this->request->post['payment_factoring004_delivery_token']) {
            $this->error['delivery_token'] = $this->language->get('error_delivery_token');
        }

        if (!$this->request->post['payment_factoring004_partner_name']) {
            $this->error['partner_name'] = $this->language->get('error_partner_name');
        }

        if (!$this->request->post['payment_factoring004_partner_code']) {
            $this->error['partner_code'] = $this->language->get('error_partner_code');
        }

        if (!$this->request->post['payment_factoring004_point_code']) {
            $this->error['point_code'] = $this->language->get('error_point_code');
        }

        if (!$this->request->post['payment_factoring004_partner_email']) {
            $this->error['partner_email'] = $this->language->get('error_partner_email');
        }

        if (!$this->request->post['payment_factoring004_partner_email']) {
            $this->error['partner_email'] = $this->language->get('error_partner_email');
        }

        if (!$this->request->post['payment_factoring004_partner_website']) {
            $this->error['partner_website'] = $this->language->get('error_partner_website');
        }

        return !$this->error;
    }

    private function getDeliveryItems()
    {
        $this->load->model('setting/extension');
        $extensions = $this->model_setting_extension->getInstalled('shipping');

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
