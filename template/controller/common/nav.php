<?php

class ControllerCommonNav extends PT_Controller
{
    public function index()
    {
        $this->load->language('common/nav');

        $data['name'] = $this->config->get('config_name');

        if (is_file(DIR_IMAGE . $this->config->get('config_logo')) && is_file(DIR_IMAGE . $this->config->get('config_district_logo')) && is_file(DIR_IMAGE . $this->config->get('config_governor_logo'))) {
            $data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
            
            $data['district_logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_district_logo');
            $data['governor_logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_governor_logo');
        } else {
            
            $data['logo'] = '';
            $data['district_logo'] = '';
            $data['governor_logo'] = '';
        }


        $data['home'] = $this->url->link('common/home');
        $data['contact'] = $this->url->link('information/contact');
        $data['about'] = $this->url->link('information/about');
        $data['history'] = $this->url->link('information/history');
        $data['object'] = $this->url->link('information/object');
        $data['president'] = $this->url->link('information/president');
        $data['test'] = $this->url->link('information/four_way_test');
        $data['governor'] = $this->url->link('information/governor');
        $data['video'] = $this->url->link('information/video');
        $data['link'] = $this->url->link('information/link');
        $data['resource'] = $this->url->link('information/resource');
        $data['project'] = $this->url->link('information/project');
        $data['event'] = $this->url->link('information/event');
        $data['club'] = $this->url->link('information/club');
        $data['club_history'] = $this->url->link('information/club_history');
        $data['club_leadership'] = $this->url->link('information/club_leadership');
        $data['donate_now'] = $this->url->link('information/donate_now');
        $data['honorary_rotarian'] = $this->url->link('information/honorary_rotarian');
        $data['join_us'] = $this->url->link('information/join_us');
        $data['trust_detail'] = $this->url->link('information/trust_detail');
        $data['our_service'] = $this->url->link('information/our_service');
        $data['news'] = $this->url->link('information/news');
        $data['download'] = $this->url->link('information/download');

        # information
        $this->load->model('information/information_group');
        $this->load->model('information/information');

        $data['information'] = array();

        $information = $this->model_information_information_group->getInformationGroups();
        
        foreach ($information as $info){
        
            $children_data = array();
            
            $children = $this->model_information_information->getInformationsByGroupId($info['information_group_id']);
        
            foreach ($children as $child) {
                $children_data[] = array(
                    'title'         => $child['title'],
                    'description'   => $child['description'],
                    'href'          => $this->url->link('information/information', 'path=' . $info['information_group_id'] . '_' . $child['information_id'])
                );
            }
            
            $data['information'][] = array(
                    'name'         => $info['group_name'],
                    'children'     => $children_data,
                    'href'         => $this->url->link('information/information', 'path=' . $info['information_group_id'])
                );
        }
        // echo '<pre>';
        // print_r($data['information']); exit;

        return $this->load->view('common/nav', $data);
    }
}
