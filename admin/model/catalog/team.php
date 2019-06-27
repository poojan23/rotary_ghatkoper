<?php

class ModelCatalogTeam extends PT_Model
{
    public function addTeam($data)
    {
        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "team SET  name = '" . $this->db->escape((string)$data['name']) . "', club_id = '" . ((int)$data['club_id']) . "', position = '" . $this->db->escape((string)$data['position']) . "',mobile = '" . $this->db->escape((string)$data['mobile']) . "',email = '" . $this->db->escape((string)$data['email']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW(), date_added = NOW()");

        return $query;
    }

    public function editTeam($team_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "team SET name = '" . $this->db->escape((string)$data['name']) . "', club_id = '" . ((int)$data['club_id']) . "', position = '" . $this->db->escape((string)$data['position']) . "',mobile = '" . $this->db->escape((string)$data['mobile']) . "',email = '" . $this->db->escape((string)$data['email']) . "', status = '" . (isset($data['status']) ? (int)$data['status'] : 0) . "', date_modified = NOW() WHERE team_id = '" . (int)$team_id . "'");
    }

    public function deleteTeam($team_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "team WHERE team_id = '" . (int)$team_id . "'");

        $this->cache->delete('team');
    }

    public function getTeam($team_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "team WHERE team_id = '" . (int)$team_id . "'");

        return $query->row;
    }
    public function getTeams()
    {
        $query = $this->db->query("SELECT  t.*,c.club_name FROM " . DB_PREFIX . "team t LEFT JOIN " . DB_PREFIX . "club c ON t.club_id = c.club_id WHERE t.status = '1'");

        return $query->rows;
    }
}
