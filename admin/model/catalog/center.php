<?php

class ModelCatalogCenter extends PT_Model
{
    public function addCenter($data)
    {
        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "rotary_center SET   club_id = '" . ((int)$data['club_id']) . "', address = '" . $this->db->escape((string)$data['address']) . "', contact_person = '" . $this->db->escape((string)$data['person']) . "',mobile = '" . $this->db->escape((string)$data['mobile']) . "',email = '" . $this->db->escape((string)$data['email']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW(), date_added = NOW()");

        return $query;
    }

    public function editCenter($center_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "rotary_center SET club_id = '" . ((int)$data['club_id']) . "', address = '" . $this->db->escape((string)$data['address']) . "', contact_person = '" . $this->db->escape((string)$data['person']) . "',mobile = '" . $this->db->escape((string)$data['mobile']) . "',email = '" . $this->db->escape((string)$data['email']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW() WHERE center_id = '" . (int)$center_id . "'");
    }

    public function deleteCenter($center_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "rotary_center WHERE center_id = '" . (int)$center_id . "'");

        $this->cache->delete('center');
    }

    public function getCenter($center_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "rotary_center WHERE center_id = '" . (int)$center_id . "'");

        return $query->row;
    }
    public function getCenters()
    {
        $query = $this->db->query("SELECT  c.*,cl.club_name FROM " . DB_PREFIX . "rotary_center c LEFT JOIN " . DB_PREFIX . "club cl ON c.club_id = cl.club_id WHERE c.status = '1'");

        return $query->rows;
    }
}
