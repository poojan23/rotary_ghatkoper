<?php

class ControllerCommonNav extends PT_Controller
{
    public function index()
    {
        if (isset($this->request->get['user_token']) && isset($this->session->data['user_token']) && ((string)$this->request->get['user_token'] == $this->session->data['user_token'])) {
            $this->load->language('common/nav');

            # Create a 3 level menu array
            # Level 2 can not have children

            # Menu
            $data['menus'][] = array(
                'id'        => 'menu-dashboard',
                'icon'      => 'fa-tachometer-alt',
                'name'      => $this->language->get('text_dashboard'),
                'href'      => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token']),
                'children'  => array()
            );

            # Catalog
            $catalog = array();
                        
//            if ($this->user->hasPermission('access', 'catalog/austin_governor')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_austin_governor'),
//                    'href'      => $this->url->link('catalog/austin_governor', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
            
//            if ($this->user->hasPermission('access', 'catalog/category')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_category'),
//                    'href'      => $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
            
//            if ($this->user->hasPermission('access', 'catalog/club')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_club'),
//                    'href'      => $this->url->link('catalog/club', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
            
//            if ($this->user->hasPermission('access', 'catalog/exchange_rate')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_exchange_rate'),
//                    'href'      => $this->url->link('catalog/exchange_rate', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
                        
//            if ($this->user->hasPermission('access', 'catalog/team')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_team'),
//                    'href'      => $this->url->link('catalog/team', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
//                        
//            if ($this->user->hasPermission('access', 'catalog/citation')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_citation'),
//                    'href'      => $this->url->link('catalog/citation', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
            
            if ($this->user->hasPermission('access', 'catalog/information')) {
                $catalog[] = array(
                    'name'      => $this->language->get('text_information'),
                    'href'      => $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }
            
            if ($this->user->hasPermission('access', 'catalog/information_group')) {
                $catalog[] = array(
                    'name'      => $this->language->get('text_information_group'),
                    'href'      => $this->url->link('catalog/information_group', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }
            
             if ($this->user->hasPermission('access', 'catalog/download')) {
                $catalog[] = array(
                    'name'      => $this->language->get('text_download'),
                    'href'      => $this->url->link('catalog/download', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }
//            if ($this->user->hasPermission('access', 'catalog/governor')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_governor'),
//                    'href'      => $this->url->link('catalog/governor', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
//            
//            if ($this->user->hasPermission('access', 'catalog/gml')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_gml'),
//                    'href'      => $this->url->link('catalog/gml', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
//            
//            if ($this->user->hasPermission('access', 'catalog/center')) {
//                $catalog[] = array(
//                    'name'      => $this->language->get('text_center'),
//                    'href'      => $this->url->link('catalog/center', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }

            if ($catalog) {
                $data['menus'][] = array(
                    'id'        => 'menu-catalog',
                    'icon'      => 'fa-tags',
                    'name'      => $this->language->get('text_catalog'),
                    'href'      => '',
                    'children'  => $catalog
                );
            }

            # Design
            $design = array();
            
            if ($this->user->hasPermission('access', 'design/banner')) {
                $design[] = array(
                    'name'      => $this->language->get('text_banner'),
                    'href'      => $this->url->link('design/banner', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($design) {
                $data['menus'][] = array(
                    'id'        => 'menu-design',
                    'icon'      => 'fa-desktop',
                    'name'      => $this->language->get('text_design'),
                    'href'      => '',
                    'children'  => $design
                );
            }
            
            # Event
            $event = array();
            
            if ($this->user->hasPermission('access', 'catalog/event')) {
                $event[] = array(
                    'name'      => $this->language->get('text_event'),
                    'href'      => $this->url->link('catalog/event', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }
   
            if ($event) {
                $data['menus'][] = array(
                    'id'        => 'menu-design',
                    'icon'      => 'fa-desktop',
                    'name'      => $this->language->get('text_event'),
                    'href'      => '',
                    'children'  => $event
                );
            }
            
            # News
            $news = array();
            
            if ($this->user->hasPermission('access', 'news/news')) {
                $news[] = array(
                    'name'      => $this->language->get('text_news'),
                    'href'      => $this->url->link('news/news', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }
   
            if ($news) {
                $data['menus'][] = array(
                    'id'        => 'menu-design',
                    'icon'      => 'fa-desktop',
                    'name'      => $this->language->get('text_news'),
                    'href'      => '',
                    'children'  => $news
                );
            }
            
            # Project
            $project = array();
            
            if ($this->user->hasPermission('access', 'catalog/project')) {
                $project[] = array(
                    'name'      => $this->language->get('text_project'),
                    'href'      => $this->url->link('catalog/project', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }
   
            if ($project) {
                $data['menus'][] = array(
                    'id'        => 'menu-design',
                    'icon'      => 'fa-desktop',
                    'name'      => $this->language->get('text_project'),
                    'href'      => '',
                    'children'  => $project
                );
            }
            

//            # Enquiry
//            if ($this->user->hasPermission('access', 'common/enquiry')) {
//                $data['menus'][] = array(
//                    'id'        => 'menu-enquiry',
//                    'icon'      => 'fa-envelope',
//                    'name'      => $this->language->get('text_enquiry'),
//                    'href'      => $this->url->link('common/enquiry', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
//
//            # Testimonial
//            if ($this->user->hasPermission('access', 'common/testimonial')) {
//                $data['menus'][] = array(
//                    'id'        => 'menu-testimonial',
//                    'icon'      => 'fa-pen-alt',
//                    'name'      => $this->language->get('text_testimonial'),
//                    'href'      => $this->url->link('common/testimonial', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }
//            
//            # Exchange Rate
//            $data['menus'][] = array(
//                'id'        => 'menu-review',
//                'icon'      => 'fa-money-bill-alt',
//                'name'      => $this->language->get('text_exchange_rate'),
//                'href'      => $this->url->link('catalog/exchange_rate', 'user_token=' . $this->session->data['user_token']),
//                'children'  => array()
//            );
            
//            # Review
//            $data['menus'][] = array(
//                'id'        => 'menu-review',
//                'icon'      => 'fa-comment-alt',
//                'name'      => $this->language->get('text_club'),
//                'href'      => $this->url->link('catalog/club', 'user_token=' . $this->session->data['user_token']),
//                'children'  => array()
//            );
            # Settings
            # System
            $system = array();

            if ($this->user->hasPermission('access', 'setting/store')) {
                $system[] = array(
                    'name'      => $this->language->get('text_store'),
                    'href'      => $this->url->link('setting/store', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            # Users
            $user = array();

            if ($this->user->hasPermission('access', 'user/user')) {
                $user[] = array(
                    'name'      => $this->language->get('text_user'),
                    'href'      => $this->url->link('user/user', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($this->user->hasPermission('access', 'user/user_permission')) {
                $user[] = array(
                    'name'      => $this->language->get('text_user_group'),
                    'href'      => $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($user) {
                $system[] = array(
                    'name'      => $this->language->get('text_user'),
                    'href'      => '',
                    'children'  => $user
                );
            }

            # Localisation
            $localisation = array();

//            if ($this->user->hasPermission('access', 'localisation/language')) {
//                $localisation[] = array(
//                    'name'      => $this->language->get('text_language'),
//                    'href'      => $this->url->link('localisation/language', 'user_token=' . $this->session->data['user_token']),
//                    'children'  => array()
//                );
//            }

            if ($this->user->hasPermission('access', 'localisation/country')) {
                $localisation[] = array(
                    'name'      => $this->language->get('text_country'),
                    'href'      => $this->url->link('localisation/country', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($this->user->hasPermission('access', 'localisation/zone')) {
                $localisation[] = array(
                    'name'      => $this->language->get('text_zone'),
                    'href'      => $this->url->link('localisation/zone', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($localisation) {
                $system[] = array(
                    'name'      => $this->language->get('text_localisation'),
                    'href'      => '',
                    'children'  => $localisation
                );
            }

            # Tools
            $maintenance = array();

            if ($this->user->hasPermission('access', 'tool/upgrade')) {
                $maintenance[] = array(
                    'name'      => $this->language->get('text_upgrade'),
                    'href'      => $this->url->link('tool/upgrade', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($this->user->hasPermission('access', 'tool/backup')) {
                $maintenance[] = array(
                    'name'      => $this->language->get('text_backup'),
                    'href'      => $this->url->link('tool/backup', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($this->user->hasPermission('access', 'tool/upload')) {
                $maintenance[] = array(
                    'name'      => $this->language->get('text_upload'),
                    'href'      => $this->url->link('tool/upload', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($this->user->hasPermission('access', 'tool/log')) {
                $maintenance[] = array(
                    'name'      => $this->language->get('text_log'),
                    'href'      => $this->url->link('tool/log', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($maintenance) {
                $system[] = array(
                    'name'      => $this->language->get('text_maintenance'),
                    'href'      => '',
                    'children'  => $maintenance
                );
            }

            if ($system) {
                $data['settings'][] = array(
                    'id'        => 'menu-system',
                    'icon'      => 'fa-cog',
                    'name'      => $this->language->get('text_system'),
                    'href'      => '',
                    'children'  => $system
                );
            }

            # Reports
            $report = array();

            if ($this->user->hasPermission('access', 'report/report')) {
                $report[] = array(
                    'name'      => $this->language->get('text_reports'),
                    'href'      => $this->url->link('report/report', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($this->user->hasPermission('access', 'report/online')) {
                $report[] = array(
                    'name'      => $this->language->get('text_online'),
                    'href'      => $this->url->link('report/online', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($this->user->hasPermission('access', 'report/statistics')) {
                $report[] = array(
                    'name'      => $this->language->get('text_statistics'),
                    'href'      => $this->url->link('report/statistics', 'user_token=' . $this->session->data['user_token']),
                    'children'  => array()
                );
            }

            if ($report) {
                $data['settings'][] = array(
                    'id'        => 'menu-reports',
                    'icon'      => 'fa-chart-bar',
                    'name'      => $this->language->get('text_reports'),
                    'href'      => '',
                    'children'  => $report
                );
            }

            $data['settings'][] = array(
                'id'        => 'menu-logout',
                'icon'      => 'fa-sign-out-alt',
                'name'      => $this->language->get('text_logout'),
                'href'      => $this->url->link('user/logout', 'user_token=' . $this->session->data['user_token']),
                'children'  => array()
            );

            $data['home'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token']);
            $data['profile'] = $this->url->link('user/profile', 'user_token=' . $this->session->data['user_token']);

            # User
            $this->load->model('tool/image');

            $data['username'] = '';
            $data['user_group'] = '';
            $data['image'] = $this->model_tool_image->resize('profile.png', 45, 45);

            $this->load->model('user/user');

            $user_info = $this->model_user_user->getUser($this->user->getId());

            if ($user_info) {
                $data['username'] = $user_info['name'];
                $data['user_group'] = $user_info['user_group'];

                if (is_file(DIR_IMAGE . html_entity_decode($user_info['image'], ENT_QUOTES, 'UTF-8'))) {
                    $data['image'] = $this->model_tool_image->resize(html_entity_decode($user_info['image'], ENT_QUOTES, 'UTF-8'), 45, 45);
                }
            }

            return $this->load->view('common/nav', $data);
        }
    }
}
