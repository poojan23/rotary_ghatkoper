<?php

class ModelCatalogGml extends PT_Model
{
    public function addGml($data) {
        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "gml SET name = '" . $this->db->escape($data['name']) . "',filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_modified = NOW(), date_added = NOW()");

        return $query;
    }

    public function editGml($gml_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "gml SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_modified = NOW() WHERE gml_id = '" . (int)$gml_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "gml_description WHERE gml_id = '" . (int)$gml_id . "'");

        foreach($data['gml_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "gml_description SET gml_id = '" . (int)$gml_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }
    }

    public function deleteGml($gml_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "gml WHERE gml_id = '" . (int)$gml_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "gml_description WHERE gml_id = '" . (int)$gml_id . "'");
    }

    public function getGml($gml_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "gml WHERE gml_id = '" . (int)$gml_id . "'");

        return $query->row;
    }

    public function getGmls() {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "gml");

        return $query->rows;
    }

    public function getGmlByName($name) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gml_description WHERE name = '" . $this->db->escape($name) . "'");

        return $query->row;
    }

    public function getTotalGmls() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gml");

        return $query->row['total'];
    }

    public function getSumGmls() {
        $query = $this->db->query("SELECT SUM(viewed) AS sum FROM " . DB_PREFIX . "gml");

        return $query->row['sum'];
    }
}
