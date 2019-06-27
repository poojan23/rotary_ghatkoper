<?php

class ControllerCatalogInformationGroup extends PT_Controller {

    private $error = array();

    public function index() {
        $this->load->language('catalog/information_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/information_group');

        $this->getList();
    }

    public function add() {
        $this->load->language('catalog/information_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/information_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_information_group->addInformationGroup($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/information_group', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/information_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/information_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_information_group->editInformationGroup($this->request->get['information_group_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/information_group', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('catalog/information_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/information_group');
       
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $information_group_id) {
                $this->model_catalog_information_group->deleteInformationGroup($information_group_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/information_group', 'user_token=' . $this->session->data['user_token']));
        }

        $this->getList();
    }

    protected function getList() {
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
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/information_group', 'user_token=' . $this->session->data['user_token'])
        );

        $data['add'] = $this->url->link('catalog/information_group/add', 'user_token=' . $this->session->data['user_token']);
        $data['delete'] = $this->url->link('catalog/information_group/delete', 'user_token=' . $this->session->data['user_token']);

        $data['information_groups'] = array();

        $results = $this->model_catalog_information_group->getInformationGroups();

        foreach ($results as $result) {
            $data['information_groups'][] = array(
                'information_group_id' => $result['information_group_id'],
                'group_name' => $result['group_name'],
                'sort_order' => $result['sort_order'],
                'edit' => $this->url->link('catalog/information_group/edit', 'user_token=' . $this->session->data['user_token'] . '&information_group_id=' . $result['information_group_id']),
                'delete' => $this->url->link('catalog/information_group/delete', 'user_token=' . $this->session->data['user_token'] . '&information_group_id=' . $result['information_group_id'])
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

        $this->response->setOutput($this->load->view('catalog/information_group_list', $data));
    }

    protected function getForm() {
        $this->document->addStyle("view/dist/plugins/iCheck/all.css");
        $this->document->addScript("view/dist/plugins/ckeditor/ckeditor.js");
        $this->document->addScript("view/dist/plugins/ckeditor/adapters/jquery.js");
        $this->document->addScript("view/dist/plugins/iCheck/icheck.min.js");

        $data['text_form'] = !isset($this->request->get['information_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['warning_err'] = $this->error['warning'];
        } else {
            $data['warning_err'] = '';
        }

        if (isset($this->error['group_name'])) {
            $data['group_name_err'] = $this->error['group_name'];
        } else {
            $data['group_name_err'] = array();
        }

        if (isset($this->error['url'])) {
            $data['url_err'] = $this->error['url'];
        } else {
            $data['url_err'] = array();
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/information_group', 'user_token=' . $this->session->data['user_token'])
        );

        if (!isset($this->request->get['information_group_id'])) {
            $data['action'] = $this->url->link('catalog/information_group/add', 'user_token=' . $this->session->data['user_token']);
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_add'),
                'href' => $this->url->link('catalog/information_group/add', 'user_token=' . $this->session->data['user_token'])
            );
        } else {
            $data['action'] = $this->url->link('catalog/information_group/edit', 'user_token=' . $this->session->data['user_token'] . '&information_group_id=' . $this->request->get['information_group_id']);
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('catalog/information_group/edit', 'user_token=' . $this->session->data['user_token'] . '&information_group_id=' . $this->request->get['information_group_id'])
            );
        }

        $data['cancel'] = $this->url->link('catalog/information_group', 'user_token=' . $this->session->data['user_token']);

        if (isset($this->request->get['information_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $information_group_info = $this->model_catalog_information_group->getInformationGroup($this->request->get['information_group_id']);
        }
      
        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/language');

        $this->load->model('catalog/information');

        $data['pages'] = $this->model_catalog_information->getInformations();

        if (isset($this->request->post['group_name'])) {
            $data['group_name'] = $this->request->post['group_name'];
        } elseif (!empty($information_group_info)) {
            $data['group_name'] = $information_group_info['group_name'];
        } else {
            $data['group_name'] = '';
        }

        if (isset($this->request->post['information_id'])) {
            $data['information_id'] = $this->request->post['information_id'];
        } elseif (!empty($information_group_info)) {
            $data['information_id'] = $information_group_info['information_id'];
        } else {
            $data['information_id'] = '';
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($information_group_info)) {
            $data['sort_order'] = $information_group_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }
         if (isset($this->request->get['information_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $information_seo = $this->model_catalog_information_group->getInformationGroupSeoUrls($this->request->get['information_group_id']);
        }
       
        if (isset($this->request->post['information_seo_url'])) {
            $data['information_seo_url'] = $this->request->post['information_seo_url'];
        } elseif (!empty($information_seo)) {
            $data['information_seo'] = $information_seo['keyword'];
        } else {
            $data['information_seo'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($information_group_info)) {
            $data['status'] = $information_group_info['status'];
        } else {
            $data['status'] = true;
        }

        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/information_group_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/information_group')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if ((utf8_strlen(trim($this->request->post['group_name'])) < 1) || (utf8_strlen(trim($this->request->post['group_name'])) > 32)) {
            $this->error['group_name'] = $this->language->get('error_group_name');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('delete', 'catalog/information_group')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function icons() {
        $json = array();

        if (!$json) {
            $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
            $subject = file_get_contents('view/dist/plugins/font-awesome/css/font-awesome.css');

            preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $json[] = array(
                    'icon' => $match[1],
                    'css' => implode(array(str_replace('\\', '&#x', $match[2]), ';'))
                );
            }

            // $json = var_export($json, TRUE);
            // $json = stripslashes($json);
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value;
        }

        array_multisort($sort_order, SORT_ASC, $json);

        //print_r($json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function autocomplete() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('catalog/information_group');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'sort' => 'name',
                'order' => 'ASC',
                'start' => 0,
                'limit' => 5
            );

            $results = $this->model_catalog_information_group->getInformations($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'information_group_id' => $result['information_group_id'],
                    'title' => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value;
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
