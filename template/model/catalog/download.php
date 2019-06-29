<?php

class ModelCatalogDownload extends PT_Model {

    public function updateViewed($download_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "download SET viewed = (viewed + 1) WHERE download_id = '" . (int) $download_id . "'");
    }

    public function getDownload($download_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int) $download_id . "' AND dd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getDownloads($start = 0, $limit = 20) {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY d.date_added DESC LIMIT " . (int) $start . "," . (int) $limit);

        return $query->rows;
    }

    public function getUnlinkDownloads() {
        $download_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download WHERE download_id NOT IN (SELECT download_id FROM " . DB_PREFIX . "product_to_download)");

        foreach ($query->rows as $result) {
            $download_data[$result['download_id']] = $this->getDownload($result['download_id']);
        }

        return $download_data;
    }

    public function getTotalDownloads() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "download");

        return $query->row['total'];
    }

    public function get_Downloads() {
        $curr_year = date("Y");
        $nxt_year = date("Y", strtotime('+1 year'));
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download");

        return $query->rows;
    }


}
