<?php

class ControllerExtensionPaymentFactoring004 extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/factoring004');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');
        $this->load->model('extension/payment/factoring004');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_setting_setting->editSetting('factoring004', $this->request->post);
            $this->session->data['success'] = 'Saved.';
            $this->redirect($this->url->link('marketplace/extension', 'token=' . $this->session->data['token'], 'SSL'));
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


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/factoring004', $data));

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

        $data['extensions'] = array();
        $files = glob(DIR_APPLICATION . 'controller/extension/shipping/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, '.php');
                print_r($this->config->get('shipping_' . $extension . '_status'));
                    $this->load->language('extension/shipping/' . $extension, 'extension');
                    $data['extensions'][] = array(
                        'id'         => '',
                        'name'       => $this->language->get('extension')->get('heading_title'),
                        'status'     => $this->config->get('shipping_' . $extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                        'sort_order' => $this->config->get('shipping_' . $extension . '_sort_order'),
                        'install'    => $this->url->link('extension/extension/shipping/install', 'user_token=' . $this->session->data['user_token'] . '&extension=' . $extension, true),
                        'uninstall'  => $this->url->link('extension/extension/shipping/uninstall', 'user_token=' . $this->session->data['user_token'] . '&extension=' . $extension, true),
                        'installed'  => in_array($extension, $extensions),
                        'edit'       => $this->url->link('extension/shipping/' . $extension, 'user_token=' . $this->session->data['user_token'], true)
                    );
            }
        }
        $sort_order = array();

        foreach ($data['extensions'] as $key => $value) {
            if($value['installed']){
                $add = '0';
            }else{
                $add = '1';
            }
            $sort_order[$key] = $add.$value['name'];
        }
        array_multisort($sort_order, SORT_ASC, $data['extensions']);
    }

}