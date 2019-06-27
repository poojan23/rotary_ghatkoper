<?php

class ModelCatalogProject extends PT_Model
{
    public function editProject($project_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "project SET  induction = '" . $this->db->escape((string)$data['project_induct']) . "', unlist = '" . $this->db->escape((string)$data['project_unlist']) . "', net = '" . $this->db->escape((string)$data['net_growth']) . "',review = '" . $this->db->escape((string)$data['review']) . "' WHERE project_id = '" . (int)$project_id . "'");
    }
    
    public function getProject($project_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "project WHERE project_id = '" . (int)$project_id . "'");

        return $query->row;
    }
    public function getProjects()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "project WHERE status = '1'");

        return $query->rows;
    }
}
