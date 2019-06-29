<?php

class ControllerCommonHome extends PT_Controller
{
    public function index()
    {
        
        $this->load->language('common/home');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('tool/image');

        # Home slider
        $this->load->model('design/banner');

        $data['sliders'] = array();

        $results = $this->model_design_banner->getBanner(7, 0, 8);
        foreach ($results as $result) {
                $data['sliders'][] = array(
                    'title' => $result['title'],
                    'image' => $result['image']
                );
        }

        // home count box data
        $this->load->model('club/dashboard');

        $data['trfs'] = $this->model_club_dashboard->getTotalTrfHome(); 
        $data['members'] = $this->model_club_dashboard->getTotalMemberHome(); 
        $data['clubs'] = $this->model_club_dashboard->getTotalClubHome(); 

        $data['projects'] = $this->model_club_dashboard->getTotalProjectHome(); 

        # Project
        $this->load->model('catalog/project');
        
        $data['projects'] = array();

        $results = $this->model_catalog_project->getProjects();
        
        foreach ($results as $result) {
            $data['projects'][] = array(
                'project_id' => $result['project_id'],
                'name' => $result['name'],
                'project_image' => $result['project_image'],
                'project_url' => $result['project_url'],
                'description' => $result['description']
            );
        }
        
        # Event
        $this->load->model('catalog/event');
        
        $data['events'] = array();

        $results = $this->model_catalog_event->getEvents();

        foreach ($results as $result) {
            $data['events'][] = array(
                'event_id' => $result['event_id'],
                'name' => $result['name'],
                'date' => $result['date'],
                'event_url' => $result['event_url'],
                'date' => $result['date'],
                'delete' => $this->url->link('catalog/event/delete', 'user_token=' . $this->session->data['user_token'] . '&event_id=' . $result['event_id'])
            );
        }
        
        #News
        $this->load->model('catalog/news');
        $data['newss'] = array();

        $results = $this->model_catalog_news->getNewss();
       
        foreach ($results as $result) {
            $data['newss'][] = array(
                'news_id' => $result['news_id'],
                'name' => $result['name'],
                'filename' => $result['filename'],
                'mask' => $result['mask'],
                'edit' => $this->url->link('news/news/edit', 'user_token=' . $this->session->data['user_token'] . '&news_id=' . $result['news_id'])
            );
        }
        # Blog
        # Contact
        $data['address'] = nl2br($this->config->get('config_address'));
        $data['telephone'] = $this->config->get('config_telephone');
        $data['email'] = $this->config->get('config_email');
        $data['open'] = preg_replace("/^(.*)<br.*\/?>/m", '<p>$1</p><p>', nl2br($this->config->get('config_open')));


        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('common/home', $data));
    }

    public function send()
    {
        $this->load->language('common/home');

        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
                $json['error']['name'] = $this->language->get('error_name');
            }

            if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
                $json['error']['email'] = $this->language->get('error_email');
            }

            if ((utf8_strlen($this->request->post['message']) < 10) || (utf8_strlen($this->request->post['message']) > 3000)) {
                $json['error']['message'] = $this->language->get('error_message');
            }

            if (!$json) {
                $json['success'] = $this->language->get('text_success');

                if (filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
                    $mail = new Mail($this->config->get('config_mail_engine'));
                    $mail->parameter = $this->config->get('config_mail_parameter');
                    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                    $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                    $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

                    $mail->setTo($this->config->get('config_email'));
                    $mail->setFrom($this->request->post['email']);
                    $mail->setReplyTo($this->request->post['email']);
                    $mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
                    $mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
                    $mail->setText($this->request->post['message']);
                    $mail->send();
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
