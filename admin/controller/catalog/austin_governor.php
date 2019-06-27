<?php

class ControllerCatalogAustinGovernor extends PT_Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('catalog/austin_governor');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/austin_governor');

        $this->getList();
    }

    public function add()
    {
        $this->load->language('catalog/austin_governor');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/austin_governor');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_austin_governor->addAustinGovernor($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/austin_governor', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('catalog/austin_governor');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/austin_governor');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
            $this->model_catalog_austin_governor->editAustinGovernor($this->request->get['austin_governor_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/austin_governor', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('catalog/austin_governor');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/austin_governor');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $austin_governor_id) {
                $this->model_catalog_austin_governor->deleteAustinGovernor($austin_governor_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/austin_governor', 'user_token=' . $this->session->data['user_token']));
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
            'href'  => $this->url->link('catalog/austin_governor', 'user_token=' . $this->session->data['user_token'])
        );

        $data['add'] = $this->url->link('catalog/austin_governor/add', 'user_token=' . $this->session->data['user_token']);
        $data['delete'] = $this->url->link('catalog/austin_governor/delete', 'user_token=' . $this->session->data['user_token']);

        $data['austingovernors'] = array();

        $results = $this->model_catalog_austin_governor->getAustinGovernors();

        foreach ($results as $result) {
            $data['austingovernors'][] = array(
                'austin_governor_id'        => $result['austin_governor_id'],
                'name'                      => $result['name'],
                'edit'                      => $this->url->link('catalog/austin_governor/edit', 'user_token=' . $this->session->data['user_token'] . '&austin_governor_id=' . $result['austin_governor_id'])
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

        $this->response->setOutput($this->load->view('catalog/austin_governor_list', $data));
    }

    protected function getForm()
    {
        $this->document->addStyle("view/dist/plugins/iCheck/all.css");
        $this->document->addScript("view/dist/plugins/ckeditor/ckeditor.js");
        $this->document->addScript("view/dist/plugins/ckeditor/adapters/jquery.js");
        $this->document->addScript("view/dist/plugins/iCheck/icheck.min.js");
        
        $data['text_form'] = !isset($this->request->get['austin_governor_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['warning_err'] = $this->error['warning'];
        } else {
            $data['warning_err'] = '';
        }

        if (isset($this->error['austin_governor'])) {
            $data['austin_governor_err'] = $this->error['austin_governor'];
        } else {
            $data['austin_governor_err'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('text_home'),
            'href'  => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('heading_title'),
            'href'  => $this->url->link('catalog/austin_governor', 'user_token=' . $this->session->data['user_token'])
        );

        if (!isset($this->request->get['austin_governor_id'])) {
            $data['action'] = $this->url->link('catalog/austin_governor/add', 'user_token=' . $this->session->data['user_token']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_add'),
                'href'  => $this->url->link('catalog/austin_governor/add', 'user_token=' . $this->session->data['user_token'])
            );
        } else {
            $data['action'] = $this->url->link('catalog/austin_governor/edit', 'user_token=' . $this->session->data['user_token'] . '&austin_governor_id=' . $this->request->get['austin_governor_id']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_edit'),
                'href'  => $this->url->link('catalog/austin_governor/edit', 'user_token=' . $this->session->data['user_token'])
            );
        }

        $data['cancel'] = $this->url->link('catalog/austin_governor', 'user_token=' . $this->session->data['user_token']);

        if (isset($this->request->get['austin_governor_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $austin_governor_info = $this->model_catalog_austin_governor->getAustinGovernor($this->request->get['austin_governor_id']);
        }

        if (isset($this->request->post['austin_governor'])) {
            $data['austin_governor'] = $this->request->post['austin_governor'];
        } elseif (!empty($austin_governor_info)) {
            $data['austin_governor'] = $austin_governor_info['name'];
        } else {
            $data['austin_governor'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($austin_governor_info)) {
            $data['status'] = $austin_governor_info['status'];
        } else {
            $data['status'] = true;
        }

        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/austin_governor_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'catalog/austin_governor')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if ((utf8_strlen(trim($this->request->post['austin_governor'])) < 1) || (utf8_strlen(trim($this->request->post['austin_governor'])) > 32)) {
            $this->error['austin_governor'] = $this->language->get('error_austin_governor');
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('delete', 'catalog/austin_governor')) {
            $this->error['warning'] = $this->language->get('error_delete');
        }

        foreach ($this->request->post['selected'] as $austin_governor_id) {
            if ($this->user->getId() == $austin_governor_id) {
                $this->error['warning'] = $this->language->get('error_account');
            }
        }

        return !$this->error;
    }
}
