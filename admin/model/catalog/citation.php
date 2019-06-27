<?php

class ModelCatalogCitation extends PT_Model
{
    public function addCitation($data)
    {
        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "citation SET  content = '" . $this->db->escape((string)$data['content']) . "', value = '" . $this->db->escape((string)$data['value']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW(), date_added = NOW()");

        return $query;
    }

    public function editCitation($citation_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "citation SET  content = '" . $this->db->escape((string)$data['content']) . "', value = '" . $this->db->escape((string)$data['value']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW()WHERE citation_id = '" . (int)$citation_id . "'");
    }

    public function deleteCitation($citation_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "citation WHERE citation_id = '" . (int)$citation_id . "'");

        $this->cache->delete('citation');
    }

    public function getCitation($citation_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "citation WHERE citation_id = '" . (int)$citation_id . "'");

        return $query->row;
    }
    public function getCitations()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "citation WHERE status = '1'");

        return $query->rows;
    }
}
