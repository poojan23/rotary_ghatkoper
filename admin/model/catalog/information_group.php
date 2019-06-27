<?php

class ModelCatalogInformationGroup extends PT_Model
{
    public function addInformationGroup($data)
    {
        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "information_group SET  group_name = '" . $this->db->escape((string)$data['group_name']) . "',information_id = '" . (int)$data['information_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW(), date_added = NOW()");
        $information_group_id = $this->db->lastInsertId();
        # SEO URL
        if (isset($data['information_seo_url'])) {
           
            $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET  query = 'information_group_id=" . (int)$information_group_id . "', keyword = '" . $this->db->escape((string)$data['information_seo_url']) . "', push = '" . $this->db->escape('url=information/information_group&information_group_id=' . (int)$information_group_id) . "'");
              
        }
        return $query;
    }

    public function editInformationGroup($information_group_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "information_group SET group_name = '" . $this->db->escape((string)$data['group_name']) . "',information_id = '" . (int)$data['information_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW() WHERE information_group_id = '" . (int)$information_group_id . "'");
    }

    public function deleteInformationGroup($information_group_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "information_group WHERE information_group_id = '" . (int)$information_group_id . "'");

        $this->cache->delete('information_group');
    }

    public function getInformationGroup($information_group_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information_group WHERE information_group_id = '" . (int)$information_group_id . "'");

        return $query->row;
    }
    public function getInformationGroups()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information_group");

        return $query->rows;
    }
        public function getInformationGroupSeoUrls($information_group_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'information_group_id=" . (int)$information_group_id . "'");

        return $query->row;
    }
}
