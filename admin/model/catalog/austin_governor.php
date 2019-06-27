<?php

class ModelCatalogAustinGovernor extends PT_Model
{
    public function addAustinGovernor($data)
    {
//        echo "INSERT INTO " . DB_PREFIX . "austin_governor SET  name = '" . $this->db->escape((string)$data['austin_governor']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW(), date_added = NOW()";exit;
        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "austin_governor SET  name = '" . $this->db->escape((string)$data['austin_governor']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW(), date_added = NOW()");

        return $query;
    }

    public function editAustinGovernor($austin_governor_id, $data)
    {        
        $this->db->query("UPDATE " . DB_PREFIX . "austin_governor SET name = '" . $this->db->escape((string)$data['austin_governor']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW() WHERE austin_governor_id = '" . (int)$austin_governor_id . "'");
    }

    public function deleteAustinGovernor($austin_governor_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "austin_governor WHERE austin_governor_id = '" . (int)$austin_governor_id . "'");

        $this->cache->delete('austin_governor');
    }

    public function getAustinGovernor($austin_governor_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "austin_governor WHERE austin_governor_id = '" . (int)$austin_governor_id . "'");

        return $query->row;
    }
    public function getAustinGovernors()
    {
        $query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "austin_governor  WHERE status = '1'");

        return $query->rows;
    }

}