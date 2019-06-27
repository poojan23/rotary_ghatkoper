<?php

class ControllerCatalogExchangeRate extends PT_Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('catalog/exchange_rate');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/exchange_rate');

        $this->getList();
    }

    public function edit()
    {
        $this->load->language('catalog/exchange_rate');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/exchange_rate');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_catalog_exchange_rate->editExchangeRate($this->request->get['exchange_rate_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/exchange_rate', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }


    protected function getList()
    {
        $this->document->addStyle("view/dist/plugins/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css");
        $this->document->addStyle("view/dist/plugins/DataTables/Buttons-1.5.6/css/buttons.bootstrap4.min.css");
        $this->document->addStyle("view/dist/plugins/DataTables/FixedHeader-3.1.4/css/fixedHeader.bootstrap4.min.css");
        $this->document->addStyle("view/dist/plugins/DataTables/Responsive-2.2.2/css/responsive.bootstrap4.min.css");
        $this->document->addScript("view/dist/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/dataTables.buttons.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/buttons.bootstrap4.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/JSZip-2.5.0/jszip.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/pdfmake-0.1.36/pdfmake.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/pdfmake-0.1.36/vfs_fonts.js");
        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/buttons.html5.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/buttons.print.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/buttons.colVis.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/FixedHeader-3.1.4/js/dataTables.fixedHeader.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/FixedHeader-3.1.4/js/fixedHeader.bootstrap4.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/Responsive-2.2.2/js/dataTables.responsive.min.js");
        $this->document->addScript("view/dist/plugins/DataTables/Responsive-2.2.2/js/responsive.bootstrap4.min.js");

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('text_home'),
            'href'  => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('heading_title'),
            'href'  => $this->url->link('catalog/exchange_rate', 'user_token=' . $this->session->data['user_token'])
        );

        $data['add'] = $this->url->link('catalog/exchange_rate/add', 'user_token=' . $this->session->data['user_token']);
        $data['delete'] = $this->url->link('catalog/exchange_rate/delete', 'user_token=' . $this->session->data['user_token']);

        $data['exchange_rates'] = array();

        $results = $this->model_catalog_exchange_rate->getExchangeRates();

        foreach ($results as $result) {
            $data['exchange_rates'][] = array(
                'exchange_rate_id'   => $result['exchange_rate_id'],
                'rate'               => $result['rate'],
                'date_added'         => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'edit'               => $this->url->link('catalog/exchange_rate/edit', 'user_token=' . $this->session->data['user_token'] . '&exchange_rate_id=' . $result['exchange_rate_id'])
            );
        }

        if (isset($this->error['warning'])) {
            $data['warning_err'] = $this->error['warning'];
        } else {
            $data['warning_err'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/exchange_rate_list', $data));
    }

    protected function getForm()
    {
        $this->document->addStyle("view/dist/plugins/iCheck/all.css");
        $this->document->addScript("view/dist/plugins/ckeditor/ckeditor.js");
        $this->document->addScript("view/dist/plugins/ckeditor/adapters/jquery.js");
        $this->document->addScript("view/dist/plugins/iCheck/icheck.min.js");
        
        $data['text_form'] = !isset($this->request->get['exchange_rate_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['warning_err'] = $this->error['warning'];
        } else {
            $data['warning_err'] = '';
        }

        if (isset($this->error['content'])) {
            $data['rate_err'] = $this->error['rate'];
        } else {
            $data['rate_err'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('text_home'),
            'href'  => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('heading_title'),
            'href'  => $this->url->link('catalog/exchange_rate', 'user_token=' . $this->session->data['user_token'])
        );

        if (!isset($this->request->get['exchange_rate_id'])) {
            $data['action'] = $this->url->link('catalog/exchange_rate/add', 'user_token=' . $this->session->data['user_token']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_add'),
                'href'  => $this->url->link('catalog/exchange_rate/add', 'user_token=' . $this->session->data['user_token'])
            );
        } else {
            $data['action'] = $this->url->link('catalog/exchange_rate/edit', 'user_token=' . $this->session->data['user_token'] . '&exchange_rate_id=' . $this->request->get['exchange_rate_id']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_edit'),
                'href'  => $this->url->link('catalog/exchange_rate/edit', 'user_token=' . $this->session->data['user_token'])
            );
        }

        $data['cancel'] = $this->url->link('catalog/exchange_rate', 'user_token=' . $this->session->data['user_token']);

        if (isset($this->request->get['exchange_rate_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $exchange_rate_info = $this->model_catalog_exchange_rate->getExchangeRate($this->request->get['exchange_rate_id']);
        }

        if (isset($this->request->post['rate'])) {
            $data['rate'] = $this->request->post['rate'];
        } elseif (!empty($exchange_rate_info)) {
            $data['rate'] = $exchange_rate_info['rate'];
        } else {
            $data['rate'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/exchange_rate_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'catalog/exchange_rate')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen(trim($this->request->post['rate'])) < 1) || (utf8_strlen(trim($this->request->post['rate'])) > 4)) {
            $this->error['rate'] = $this->language->get('error_exchange_rate');
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('delete', 'catalog/exchange_rate')) {
            $this->error['warning'] = $this->language->get('error_delete');
        }

        foreach ($this->request->post['selected'] as $exchange_rate_id) {
            if ($this->user->getId() == $exchange_rate_id) {
                $this->error['warning'] = $this->language->get('error_account');
            }
        }

        return !$this->error;
    }
}
