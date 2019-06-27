<?php

class ControllerCatalogGovernorApprove extends PT_Controller {

    private $error = array();

    public function index() {
        $this->load->language('catalog/governor_approve');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/governor_approve');

        $this->getList();
    }

    public function add() {
        $this->load->language('catalog/governor_approve');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/governor_approve');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_governor_approve->addTeam($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/governor_approve');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/governor_approve');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_governor_approve->editTeam($this->request->get['governor_approve_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('catalog/governor_approve');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/governor_approve');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $governor_approve_id) {
                $this->model_catalog_governor_approve->deleteTeam($governor_approve_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getList();
    }

    public function getList() {
        
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
        $this->load->language('catalog/governor_approve');
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token'])
        );

        $data['add'] = $this->url->link('catalog/governor_approve/add', 'user_token=' . $this->session->data['user_token']);
        $data['delete'] = $this->url->link('catalog/governor_approve/delete', 'user_token=' . $this->session->data['user_token']);

        $data['members'] = array();

        $this->load->model('catalog/governor_approve');

        $results = $this->model_catalog_governor_approve->getMemberById($this->request->get['club_id']);

        foreach ($results as $result) {
            $data['members'][] = array(
                'member_id'         => $result['member_id'],
                'date'              => $result['date'],
                'induction'         => $result['induction'],
                'unlist'            => $result['unlist'],
                'net'               => $result['net'],
                'points'            => $result['points'],
                'edit'              => $this->url->link('catalog/member/edit', 'user_token=' . $this->session->data['user_token'] . '&member_id=' . $result['member_id'])
            );
        }

        $data['projects'] = array();

        $project_results = $this->model_catalog_governor_approve->getProjectById($this->request->get['club_id']);
    
        foreach ($project_results as $result) {
            $data['projects'][] = array(
                'project_id'        => $result['project_id'],
                'date'              => $result['date'],
                'title'             => $result['title'],
                'description'       => $result['description'],
                'amount'            => $result['amount'],
                'no_of_beneficiary' => $result['no_of_beneficiary'],
                'edit'              => $this->url->link('catalog/project/edit', 'user_token=' . $this->session->data['user_token'] . '&project_id=' . $result['project_id'])
            );
        }
        
        $data['trfs'] = array();

        $results = $this->model_catalog_governor_approve->getTrfById($this->request->get['club_id']);

        foreach ($results as $result) {
            $data['trfs'][] = array(
                'trf_id'        => $result['trf_id'],
                'date'          => $result['date'],
                'amount_usd'    => $result['amount_usd'],
                'points'        => $result['points'],
                'edit'          => $this->url->link('catalog/trf/edit', 'user_token=' . $this->session->data['user_token'] . '&trf_id=' . $result['trf_id'])
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
            $data['selected'] = (array) $this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/approve_list', $data));
    }

    protected function getForm() {
        $this->document->addStyle("view/dist/plugins/iCheck/all.css");
        $this->document->addScript("view/dist/plugins/ckeditor/ckeditor.js");
        $this->document->addScript("view/dist/plugins/ckeditor/adapters/jquery.js");
        $this->document->addScript("view/dist/plugins/iCheck/icheck.min.js");

        $data['text_form'] = !isset($this->request->get['governor_approve_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['warning_err'] = $this->error['warning'];
        } else {
            $data['warning_err'] = '';
        }

        if (isset($this->error['position'])) {
            $data['position_err'] = $this->error['position'];
        } else {
            $data['position_err'] = '';
        }

        if (isset($this->error['name'])) {
            $data['name_err'] = $this->error['name'];
        } else {
            $data['name_err'] = '';
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
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token'])
        );

        if (!isset($this->request->get['governor_approve_id'])) {
            $data['action'] = $this->url->link('catalog/governor_approve/add', 'user_token=' . $this->session->data['user_token']);
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_add'),
                'href' => $this->url->link('catalog/governor_approve/add', 'user_token=' . $this->session->data['user_token'])
            );
        } else {
            $data['action'] = $this->url->link('catalog/governor_approve/edit', 'user_token=' . $this->session->data['user_token'] . '&governor_approve_id=' . $this->request->get['governor_approve_id']);
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('catalog/governor_approve/edit', 'user_token=' . $this->session->data['user_token'])
            );
        }

        $data['cancel'] = $this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token']);

        if (isset($this->request->get['governor_approve_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $governor_approve_info = $this->model_catalog_governor_approve->getTeam($this->request->get['governor_approve_id']);
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($governor_approve_info)) {
            $data['name'] = $governor_approve_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['club_id'])) {
            $data['club_id'] = $this->request->post['club_id'];
        } elseif (!empty($governor_approve_info)) {
            $data['club_id'] = $governor_approve_info['club_id'];
        } else {
            $data['club_id'] = '';
        }

        $this->load->model('catalog/club');

        $data['clubs'] = $this->model_catalog_club->getClubs();

        if (isset($this->request->post['position'])) {
            $data['position'] = $this->request->post['position'];
        } elseif (!empty($governor_approve_info)) {
            $data['position'] = $governor_approve_info['position'];
        } else {
            $data['position'] = '';
        }

        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } elseif (!empty($governor_approve_info)) {
            $data['email'] = $governor_approve_info['email'];
        } else {
            $data['email'] = '';
        }

        if (isset($this->request->post['mobile'])) {
            $data['mobile'] = $this->request->post['email'];
        } elseif (!empty($governor_approve_info)) {
            $data['mobile'] = $governor_approve_info['mobile'];
        } else {
            $data['mobile'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($governor_approve_info)) {
            $data['status'] = $governor_approve_info['status'];
        } else {
            $data['status'] = true;
        }

        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/governor_approve_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/governor_approve')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen(trim($this->request->post['name'])) < 1) || (utf8_strlen(trim($this->request->post['name'])) > 32)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ((utf8_strlen(trim($this->request->post['position'])) < 1) || (utf8_strlen(trim($this->request->post['position'])) > 32)) {
            $this->error['position'] = $this->language->get('error_position');
        }

        if ((utf8_strlen(trim($this->request->post['mobile'])) < 1) || (utf8_strlen(trim($this->request->post['mobile'])) > 11)) {
            $this->error['mobile'] = $this->language->get('error_mobile');
        }

        if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['email'] = $this->language->get('error_email');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('delete', 'catalog/governor_approve')) {
            $this->error['warning'] = $this->language->get('error_delete');
        }

        foreach ($this->request->post['selected'] as $governor_approve_id) {
            if ($this->user->getId() == $governor_approve_id) {
                $this->error['warning'] = $this->language->get('error_account');
            }
        }

        return !$this->error;
    }

}
