<?php

class ControllerCatalogProject extends PT_Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('catalog/project');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/project');

        $this->getList();
    }

    public function edit()
    {
        $this->load->language('catalog/project');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/project');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_catalog_project->editProject($this->request->get['project_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');
            
            $result = $this->model_catalog_project->getProject($this->request->get['project_id']);
//            print_r($result);exit;
            $this->response->redirect($this->url->link('catalog/governor_approve', 'user_token=' . $this->session->data['user_token'].'&club_id=' .$result['club_id']));
        }

        $this->getForm();
    }
//
//    protected function getList()
//    {
//        $this->document->addStyle("view/dist/plugins/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css");
//        $this->document->addStyle("view/dist/plugins/DataTables/Buttons-1.5.6/css/buttons.bootstrap4.min.css");
//        $this->document->addStyle("view/dist/plugins/DataTables/FixedHeader-3.1.4/css/fixedHeader.bootstrap4.min.css");
//        $this->document->addStyle("view/dist/plugins/DataTables/Responsive-2.2.2/css/responsive.bootstrap4.min.css");
//        $this->document->addScript("view/dist/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/dataTables.buttons.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/buttons.bootstrap4.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/JSZip-2.5.0/jszip.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/pdfmake-0.1.36/pdfmake.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/pdfmake-0.1.36/vfs_fonts.js");
//        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/buttons.html5.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/buttons.print.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/Buttons-1.5.6/js/buttons.colVis.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/FixedHeader-3.1.4/js/dataTables.fixedHeader.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/FixedHeader-3.1.4/js/fixedHeader.bootstrap4.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/Responsive-2.2.2/js/dataTables.responsive.min.js");
//        $this->document->addScript("view/dist/plugins/DataTables/Responsive-2.2.2/js/responsive.bootstrap4.min.js");
//
//        $data['breadcrumbs'] = array();
//
//        $data['breadcrumbs'][] = array(
//            'text'  => $this->language->get('text_home'),
//            'href'  => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
//        );
//
//        $data['breadcrumbs'][] = array(
//            'text'  => $this->language->get('heading_title'),
//            'href'  => $this->url->link('catalog/project', 'user_token=' . $this->session->data['user_token'])
//        );
//
//        $data['add'] = $this->url->link('catalog/project/add', 'user_token=' . $this->session->data['user_token']);
//        $data['delete'] = $this->url->link('catalog/project/delete', 'user_token=' . $this->session->data['user_token']);
//
//        $data['projects'] = array();
//
//        $results = $this->model_catalog_project->getProjects();
//
//        foreach ($results as $result) {
//            $data['projects'][] = array(
//                'project_id'   => $result['project_id'],
//                'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
//                'edit'          => $this->url->link('catalog/project/edit', 'user_token=' . $this->session->data['user_token'] . '&project_id=' . $result['project_id'])
//            );
//        }
//
//        if (isset($this->error['warning'])) {
//            $data['warning_err'] = $this->error['warning'];
//        } else {
//            $data['warning_err'] = '';
//        }
//
//        if (isset($this->session->data['success'])) {
//            $data['success'] = $this->session->data['success'];
//
//            unset($this->session->data['success']);
//        } else {
//            $data['success'] = '';
//        }
//
//        if (isset($this->request->post['selected'])) {
//            $data['selected'] = (array)$this->request->post['selected'];
//        } else {
//            $data['selected'] = array();
//        }
//
//        $data['header'] = $this->load->controller('common/header');
//        $data['nav'] = $this->load->controller('common/nav');
//        $data['footer'] = $this->load->controller('common/footer');
//
//        $this->response->setOutput($this->load->view('catalog/approve_list', $data));
//    }

    protected function getForm()
    {
        $this->document->addStyle("view/dist/plugins/iCheck/all.css");
        $this->document->addScript("view/dist/plugins/ckeditor/ckeditor.js");
        $this->document->addScript("view/dist/plugins/ckeditor/adapters/jquery.js");
        $this->document->addScript("view/dist/plugins/iCheck/icheck.min.js");
        
        $data['text_form'] = !isset($this->request->get['project_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['warning_err'] = $this->error['warning'];
        } else {
            $data['warning_err'] = '';
        }

        if (isset($this->error['month'])) {
            $data['month_err'] = $this->error['month'];
        } else {
            $data['month_err'] = '';
        }
        if (isset($this->error['year'])) {
            $data['year_err'] = $this->error['year'];
        } else {
            $data['year_err'] = '';
        }
        if (isset($this->error['project_induct'])) {
            $data['project_inducted_err'] = $this->error['project_induct'];
        } else {
            $data['project_inducted_err'] = '';
        }

        if (isset($this->error['project_unlist'])) {
            $data['project_unlist_err'] = $this->error['project_unlist'];
        } else {
            $data['project_unlist_err'] = '';
        }
        if (isset($this->error['net_growth'])) {
            $data['net_growth_err'] = $this->error['net_growth'];
        } else {
            $data['net_growth_err'] = '';
        }
        if (isset($this->error['point_accumulate'])) {
            $data['point_accumulate_err'] = $this->error['point_accumulate'];
        } else {
            $data['point_accumulate_err'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('text_home'),
            'href'  => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('heading_title'),
            'href'  => $this->url->link('catalog/project', 'user_token=' . $this->session->data['user_token'])
        );

        if (!isset($this->request->get['project_id'])) {
            $data['action'] = $this->url->link('catalog/project/add', 'user_token=' . $this->session->data['user_token']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_add'),
                'href'  => $this->url->link('catalog/project/add', 'user_token=' . $this->session->data['user_token'])
            );
        } else {
            $data['action'] = $this->url->link('catalog/project/edit', 'user_token=' . $this->session->data['user_token'] . '&project_id=' . $this->request->get['project_id']);
            $data['breadcrumbs'][] = array(
                'text'  => $this->language->get('text_edit'),
                'href'  => $this->url->link('catalog/project/edit', 'user_token=' . $this->session->data['user_token'])
            );
        }

        $data['cancel'] = $this->url->link('catalog/project', 'user_token=' . $this->session->data['user_token']);

        if (isset($this->request->get['project_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $project_info = $this->model_catalog_project->getProject($this->request->get['project_id']);
        }
        $date = $project_info['date'];
    
        $date = explode('-', $date);

        if (isset($this->request->post['month'])) {
            $data['month'] = $this->request->post['month'];
        } elseif (!empty($project_info)) {
            $data['month'] = $date[1];
        } else {
            $data['month'] = '';
        }

        if (isset($this->request->post['year'])) {
            $data['year'] = $this->request->post['year'];
        } elseif (!empty($project_info)) {
            $data['year'] = $date[0];
        } else {
            $data['year'] = '';
        }
        
        if (isset($this->request->post['project_induct'])) {
            $data['project_induct'] = $this->request->post['project_induct'];
        } elseif (!empty($project_info)) {
            $data['project_induct'] = $project_info['induction'];
        } else {
            $data['project_induct'] = '';
        }
        
        if (isset($this->request->post['review'])) {
            $data['review'] = $this->request->post['review'];
        } elseif (!empty($project_info)) {
            $data['review'] = $project_info['review'];
        } else {
            $data['review'] = '';
        }
        
        if (isset($this->request->post['project_unlist'])) {
            $data['project_unlist'] = $this->request->post['project_unlist'];
        } elseif (!empty($project_info)) {
            $data['project_unlist'] = $project_info['unlist'];
        } else {
            $data['project_unlist'] = '';
        }
        if (isset($this->request->post['net_growth'])) {
            $data['net_growth'] = $this->request->post['net_growth'];
        } elseif (!empty($project_info)) {
            $data['net_growth'] = $project_info['net'];
        } else {
            $data['net_growth'] = '';
        }
        if (isset($this->request->post['point_accumulate'])) {
            $data['point_accumulate'] = $this->request->post['point_accumulate'];
        } elseif (!empty($project_info)) {
            $data['point_accumulate'] = $project_info['net'];
        } else {
            $data['point_accumulate'] = '';
        }
        
        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/project_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'catalog/project')) {
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
        if (!$this->user->hasPermission('delete', 'catalog/project')) {
            $this->error['warning'] = $this->language->get('error_delete');
        }

        foreach ($this->request->post['selected'] as $project_id) {
            if ($this->user->getId() == $project_id) {
                $this->error['warning'] = $this->language->get('error_account');
            }
        }

        return !$this->error;
    }
}
