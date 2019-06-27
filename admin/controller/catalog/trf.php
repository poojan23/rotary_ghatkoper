<?php

class ControllerCatalogTRF extends PT_Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('catalog/trf');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/trf');

        $this->getList();
    }

    public function edit()
    {
        $this->load->language('catalog/trf');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/trf');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
//            print_r($this->request->post);exit;
            $this->model_catalog_trf->editTrf($this->request->get['trf_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');
            
            $result = $this->model_catalog_trf->getTrf($this->request->get['trf_id']);
            
            $this->response->redirect($this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token'].'&club_id=' .$result['club_id']));
        }

        $this->getForm();
    }

    protected function getForm()
    {
        $this->document->addStyle("view/dist/plugins/iCheck/all.css");
        $this->document->addScript("view/dist/plugins/ckeditor/ckeditor.js");
        $this->document->addScript("view/dist/plugins/ckeditor/adapters/jquery.js");
        $this->document->addScript("view/dist/plugins/iCheck/icheck.min.js");
        
        $data['text_form'] = !isset($this->request->get['trf_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        
        if (isset($this->error['warning'])) {
            $data['warning_err'] = $this->error['warning'];
        } else {
            $data['warning_err'] = '';
        }

        if (isset($this->error['amount_inr'])) {
            $data['amount_inr_err'] = $this->error['amount_inr'];
        } else {
            $data['amount_inr_err'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('text_home'),
            'href'  => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('heading_title'),
            'href'  => $this->url->link('catalog/trf', 'user_token=' . $this->session->data['user_token'])
        );

        if (!isset($this->request->get['trf_id'])) {
            $data['action'] = $this->url->link('catalog/trf/add', 'user_token=' . $this->session->data['user_token']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_add'),
                'href'  => $this->url->link('catalog/trf/add', 'user_token=' . $this->session->data['user_token'])
            );
        } else {
            $data['action'] = $this->url->link('catalog/trf/edit', 'user_token=' . $this->session->data['user_token'] . '&trf_id=' . $this->request->get['trf_id']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_edit'),
                'href'  => $this->url->link('catalog/trf/edit', 'user_token=' . $this->session->data['user_token'])
            );
        }
        $result = $this->model_catalog_trf->getTrf($this->request->get['trf_id']);
        $data['cancel'] = $this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token'].'&club_id=' .$result['club_id']);

        if (isset($this->request->get['trf_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $trf_info = $this->model_catalog_trf->getTrf($this->request->get['trf_id']);
        }
       
        $date = $trf_info['date'];
    
        $date = explode('-', $date);

        if (isset($this->request->post['month'])) {
            $data['month'] = $this->request->post['month'];
        } elseif (!empty($trf_info)) {
            $data['month'] = $date[1];
        } else {
            $data['month'] = '';
        }

        if (isset($this->request->post['year'])) {
            $data['year'] = $this->request->post['year'];
        } elseif (!empty($trf_info)) {
            $data['year'] = $date[0];
        } else {
            $data['year'] = '';
        }
        
        if (isset($this->request->post['amount_inr'])) {
            $data['amount_inr'] = $this->request->post['amount_inr'];
        } elseif (!empty($trf_info)) {
            $data['amount_inr'] = $trf_info['amount_inr'];
        } else {
            $data['amount_inr'] = '';
        }
        
        if (isset($this->request->post['review'])) {
            $data['review'] = $this->request->post['review'];
        } elseif (!empty($trf_info)) {
            $data['review'] = $trf_info['review'];
        } else {
            $data['review'] = '';
        }

        if (isset($this->request->post['exchange_rate'])) {
            $data['exchange_rate'] = $this->request->post['exchange_rate'];
        } elseif (!empty($trf_info)) {
            $data['exchange_rate'] = $trf_info['exchange_rate'];
        } else {
            $data['exchange_rate'] = '';
        }
        if (isset($this->request->post['amount_usd'])) {
            $data['amount_usd'] = $this->request->post['amount_usd'];
        } elseif (!empty($trf_info)) {
            $data['amount_usd'] = $trf_info['amount_usd'];
        } else {
            $data['amount_usd'] = '';
        }

        if (isset($this->request->post['notes'])) {
            $data['notes'] = $this->request->post['notes'];
        } elseif (!empty($trf_info)) {
            $data['notes'] = $trf_info['notes'];
        } else {
            $data['notes'] = '';
        }

        
        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/trf_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'catalog/trf')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen(trim($this->request->post['content'])) < 1) || (utf8_strlen(trim($this->request->post['content'])) > 255)) {
            $this->error['content'] = $this->language->get('error_content');
        }

        if ((utf8_strlen(trim($this->request->post['value'])) < 1) || (utf8_strlen(trim($this->request->post['value'])) > 255)) {
            $this->error['value'] = $this->language->get('error_value');
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('delete', 'catalog/trf')) {
            $this->error['warning'] = $this->language->get('error_delete');
        }

        foreach ($this->request->post['selected'] as $trf_id) {
            if ($this->user->getId() == $trf_id) {
                $this->error['warning'] = $this->language->get('error_account');
            }
        }

        return !$this->error;
    }
}
