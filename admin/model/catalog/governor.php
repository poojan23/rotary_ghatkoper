<?php

class ModelCatalogGovernor extends PT_Model
{
    public function addGovernor($data)
    {
        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "governor SET  year = '" . $this->db->escape((string)$data['year']) . "', club_id = '" . ((int)$data['club_id']) . "',rotarian = '" . $this->db->escape((string)$data['rotarian']) . "',classification = '" . $this->db->escape((string)$data['classification']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW(), date_added = NOW()");

        return $query;
    }

    public function editGovernor($governor_id, $data)
    {        
        $this->db->query("UPDATE " . DB_PREFIX . "governor SET year = '" . $this->db->escape((string)$data['year']) . "', club_id = '" . ((int)$data['club_id']) . "', rotarian = '" . $this->db->escape((string)$data['rotarian']) . "',classification = '" . $this->db->escape((string)$data['classification']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW() WHERE governor_id = '" . (int)$governor_id . "'");
    }

    public function deleteGovernor($governor_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "governor WHERE governor_id = '" . (int)$governor_id . "'");

        $this->cache->delete('governor');
    }

    public function getGovernor($governor_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "governor WHERE governor_id = '" . (int)$governor_id . "'");

        return $query->row;
    }
    public function getGovernors()
    {
        $query = $this->db->query("SELECT  g.*,c.club_name FROM " . DB_PREFIX . "governor g LEFT JOIN " . DB_PREFIX . "club c ON g.club_id = c.club_id WHERE g.status = '1'");

        return $query->rows;
    }

}
