<?php

class ControllerInformationJoinUs extends PT_Controller
{
    public function index()
    {
        $this->load->language('information/club');

        $this->document->setTitle($this->language->get('heading_title'));
        
         $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('text_home'),
            'href'  => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text'  => $this->language->get('heading_title'),
            'href'  => $this->url->link('information/club')
        );
        
        $this->load->model('tool/image');

        # Projects
        $this->load->model('design/banner');

        $data['projects'] = array();

        $results = $this->model_design_banner->getBanner(3, 0, 8);

        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
                $data['projects'][] = array(
                    'title' => $result['title'],
                    'image' => $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), 750, 1335)
                );
            }
        }

        # Team
        $this->load->model('catalog/team');

        $data['teams'] = array();

        $results = $this->model_catalog_team->getTeams(0, 6);

        foreach ($results as $result) {
            if ($result['image']) {
                $thumb = $this->model_tool_image->resize($result['image'], 400, 500);
            } else {
                $thumb = $this->model_tool_image->resize('default-image.png', 400, 500);
            }

            $data['teams'][] = array(
                'name'          => $result['name'],
                'designation'   => $result['designation'],
                'thumb'         => $thumb
            );
        }

        # Watch (See Our Work Showcase)

        # Testimonials
        $this->load->model('catalog/testimonial');

        $data['testimonials'] = array();

        $results = $this->model_catalog_testimonial->getTestimonials(0, 6);

        foreach ($results as $result) {
            if ($result['image']) {
                $thumb = $this->model_tool_image->resize($result['image'], 150, 150);
            } else {
                $thumb = $this->model_tool_image->resize('default-image.png', 150, 150);
            }

            $data['testimonials'][] = array(
                'name'          => $result['name'],
                'description'   => trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))),
                'designation'   => $result['designation'],
                'thumb'         => $thumb
            );
        }

        # Facts
        $this->load->model('tool/online');

        $data['website_icon'] = $this->config->get('config_website_icon');
        $data['website'] = $this->config->get('config_website');

        $data['software_icon'] = $this->config->get('config_software_icon');
        $data['software'] = $this->config->get('config_software');

        $data['client_icon'] = $this->config->get('config_client_icon');
        $data['client'] = $this->config->get('config_client');

//        $data['visitor_icon'] = $this->config->get('config_visitor_icon');
//        $data['visitor'] = ($this->model_tool_online->getTotalOnlines() > 9999) ? '9999' : $this->model_tool_online->getTotalOnlines();

        # Blog

        # Contact
        $data['address'] = nl2br($this->config->get('config_address'));
        $data['telephone'] = $this->config->get('config_telephone');
        $data['email'] = $this->config->get('config_email');
        $data['open'] = preg_replace("/^(.*)<br.*\/?>/m", '<p>$1</p><p>', nl2br($this->config->get('config_open')));

        $data['header'] = $this->load->controller('common/header');
        $data['nav'] = $this->load->controller('common/nav');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('information/join_us', $data));
    }
}
