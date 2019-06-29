<?php

class ModelCatalogNews extends PT_Model
{
    public function addNews($data) {
        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "news SET name = '" . $this->db->escape($data['name']) . "',date = '" . $this->db->escape($data['date']) . "',filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_modified = NOW(), date_added = NOW()");

        return $query;
    }

    public function editNews($news_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "news SET filename = '" . $this->db->escape($data['filename']) . "',date = '" . $this->db->escape($data['date']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_modified = NOW() WHERE news_id = '" . (int)$news_id . "'");
    }

    public function deleteNews($news_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
    }

    public function getNews($news_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");

        return $query->row;
    }

    public function getNewss() {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news ORDER BY date_added DESC LIMIT 1");

        return $query->rows;
    }

    public function get_Newss() {
        $curr_year = date("Y");
        $nxt_year = date("Y",strtotime('+1 year'));
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news  WHERE (date BETWEEN '" . $curr_year . "' AND '" . $nxt_year . "' )");

        return $query->rows;
    }
    public function getPrvNewss() {
        $prv_year = date("Y",strtotime('-1 year'));
        $curr_year = date("Y");
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news  WHERE (date BETWEEN '" . $prv_year . "' AND '" . $curr_year . "' )");

        return $query->rows;
    }

    public function getTotalNewss() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news");

        return $query->row['total'];
    }

    public function getSumNewss() {
        $query = $this->db->query("SELECT SUM(viewed) AS sum FROM " . DB_PREFIX . "news");

        return $query->row['sum'];
    }
}
