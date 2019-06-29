<?php

class ControllerInformationNews extends PT_Controller {

    public function index() {
        $this->load->language('information/news');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/news')
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

        #News
        $this->load->model('catalog/news');
        $data['newss'] = array();

        $results = $this->model_catalog_news->get_Newss();

        foreach ($results as $result) {
            $data['newss'][] = array(
                'news_id' => $result['news_id'],
                'name' => $result['name'],
                'date' => $result['date'],
                'filename' => $result['filename'],
                'mask' => $result['mask'],
                'href' => $this->url->link('information/news/download', 'news_id=' . $result['news_id'])
            );
        }

        $data['prv_newss'] = array();

        $results = $this->model_catalog_news->getPrvNewss();

        foreach ($results as $result) {
            $data['prv_newss'][] = array(
                'news_id' => $result['news_id'],
                'name' => $result['name'],
                'date' => $result['date'],
                'filename' => $result['filename'],
                'mask' => $result['mask'],
                'href' => $this->url->link('information/news/download', 'news_id=' . $result['news_id'])
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

        $this->response->setOutput($this->load->view('information/news', $data));
    }

    public function download() {
        $this->load->model('catalog/news');

        if (isset($this->request->get['news_id'])) {
            $news_id = $this->request->get['news_id'];
        } else {
            $news_id = 0;
        }

        $news_info = $this->model_catalog_news->getNews($news_id);

        if ($news_info) {
            $file = DIR_DOWNLOAD . $news_info['filename'];
            $mask = basename($news_info['mask']);

            if (!headers_sent()) {
                if (file_exists($file)) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));

                    if (ob_get_level()) {
                        ob_end_clean();
                    }

                    readfile($file, 'rb');

                    //$this->model_catalog_news->updateViewed($news_info['news_id']);

                    exit();
                } else {
                    exit("Error: Couldn't find the file $file!");
                }
            } else {
                exit("Error: Headers already sent out!");
            }
        } else {
            $this->response->redirect($this->url->link('product/news', '', true));
        }
    }

}
