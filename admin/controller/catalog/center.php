<?php

class ControllerCatalogCenter extends PT_Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('catalog/center');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/center');

        $this->getList();
    }

    public function add()
    {
        $this->load->language('catalog/center');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/center');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_center->addCenter($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/center', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('catalog/center');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/center');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_center->editCenter($this->request->get['center_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/center', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('catalog/center');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/center');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $center_id) {
                $this->model_catalog_center->deleteCenter($center_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/center', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getList();
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
            'href'  => $this->url->link('catalog/center', 'user_token=' . $this->session->data['user_token'])
        );

        $data['add'] = $this->url->link('catalog/center/add', 'user_token=' . $this->session->data['user_token']);
        $data['delete'] = $this->url->link('catalog/center/delete', 'user_token=' . $this->session->data['user_token']);

        $data['centers'] = array();

        $results = $this->model_catalog_center->getCenters();
        
        foreach ($results as $result) {
            $data['centers'][] = array(
                'center_id'     => $result['center_id'],
                'club_name'     => $result['club_name'],
                'address'       => $result['address'],
                'contact_person'=> $result['contact_person'],
                'mobile'        => $result['mobile'],
                'email'         => $result['email'],
                'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'edit'          => $this->url->link('catalog/center/edit', 'user_token=' . $this->session->data['user_token'] . '&center_id=' . $result['center_id'])
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

        $this->response->setOutput($this->load->view('catalog/center_list', $data));
    }

    protected function getForm()
    {
        $this->document->addStyle("view/dist/plugins/iCheck/all.css");
        $this->document->addScript("view/dist/plugins/ckeditor/ckeditor.js");
        $this->document->addScript("view/dist/plugins/ckeditor/adapters/jquery.js");
        $this->document->addScript("view/dist/plugins/iCheck/icheck.min.js");
        
        $data['text_form'] = !isset($this->request->get['center_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['warning_err'] = $this->error['warning'];
        } else {
            $data['warning_err'] = '';
        }

        if (isset($this->error['person'])) {
            $data['contact_person_err'] = $this->error['person'];
        } else {
            $data['contact_person_err'] = '';
        }

        if (isset($this->error['address'])) {
            $data['address_err'] = $this->error['address'];
        } else {
            $data['address_err'] = '';
        }
        
        if (isset($this->error['email'])) {
            $data['email_err'] = $this->error['email'];
        } else {
            $data['email_err'] = '';
        }
        
        if (isset($this->error['mobile'])) {
            $data['mobile_err'] = $this->error['mobile'];
        } else {
            $data['mobile_err'] = '';
        }
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('text_home'),
            'href'  => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('heading_title'),
            'href'  => $this->url->link('catalog/center', 'user_token=' . $this->session->data['user_token'])
        );

        if (!isset($this->request->get['center_id'])) {
            $data['action'] = $this->url->link('catalog/center/add', 'user_token=' . $this->session->data['user_token']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_add'),
                'href'  => $this->url->link('catalog/center/add', 'user_token=' . $this->session->data['user_token'])
            );
        } else {
            $data['action'] = $this->url->link('catalog/center/edit', 'user_token=' . $this->session->data['user_token'] . '&center_id=' . $this->request->get['center_id']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_edit'),
                'href'  => $this->url->link('catalog/center/edit', 'user_token=' . $this->session->data['user_token'])
            );
        }

        $data['cancel'] = $this->url->link('catalog/center', 'user_token=' . $this->session->data['user_token']);

        if (isset($this->request->get['center_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $center_info = $this->model_catalog_center->getCenter($this->request->get['center_id']);
        }

        if (isset($this->request->post['address'])) {
            $data['address'] = $this->request->post['address'];
        } elseif (!empty($center_info)) {
            $data['address'] = $center_info['address'];
        } else {
            $data['address'] = '';
        }
        
        if (isset($this->request->post['club_id'])) {
            $data['club_id'] = $this->request->post['club_id'];
        } elseif (!empty($center_info)) {
            $data['club_id'] = $center_info['club_id'];
        } else {
            $data['club_id'] = '';
        }

        $this->load->model('catalog/club');

        $data['clubs'] = $this->model_catalog_club->getClubs();

        if (isset($this->request->post['person'])) {
            $data['person'] = $this->request->post['person'];
        } elseif (!empty($center_info)) {
            $data['person'] = $center_info['contact_person'];
        } else {
            $data['person'] = '';
        }
        
        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } elseif (!empty($center_info)) {
            $data['email'] = $center_info['email'];
        } else {
            $data['email'] = '';
        }
        
        if (isset($this->request->post['mobile'])) {
            $data['mobile'] = $this->request->post['email'];
        } elseif (!empty($center_info)) {
            $data['mobile'] = $center_info['mobile'];
        } else {
            $data['mobile'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($center_info)) {
            $data['status'] = $center_info['status'];
        } else {
            $data['status'] = 0;
        }

        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/center_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'catalog/center')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['email'] = $this->language->get('error_email');
        }

        if ((utf8_strlen(trim($this->request->post['person'])) < 1) || (utf8_strlen(trim($this->request->post['person'])) > 32)) {
            $this->error['person'] = $this->language->get('error_person');
        }

        if ((utf8_strlen(trim($this->request->post['mobile'])) < 1) || (utf8_strlen(trim($this->request->post['mobile'])) > 11)) {
            $this->error['mobile'] = $this->language->get('error_mobile');
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('delete', 'catalog/center')) {
            $this->error['warning'] = $this->language->get('error_delete');
        }

        foreach ($this->request->post['selected'] as $center_id) {
            if ($this->user->getId() == $center_id) {
                $this->error['warning'] = $this->language->get('error_account');
            }
        }

        return !$this->error;
    }
}
