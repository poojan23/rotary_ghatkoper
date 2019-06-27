<?php

class ModelCatalogTrf extends PT_Model
{
    public function editTrf($trf_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "trf SET  amount_inr = '" . $this->db->escape((string)$data['amount_inr']) . "',amount_usd = '" . $this->db->escape((string)$data['amount_usd']) . "', review = '" . $this->db->escape((string)$data['review']) . "',notes = '" . $this->db->escape((string)$data['notes']) . "' WHERE trf_id = '" . (int)$trf_id . "'");
    }
    
    public function getTrf($trf_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "trf WHERE trf_id = '" . (int)$trf_id . "'");

        return $query->row;
    }
    public function getTrfs()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "trf WHERE status = '1'");

        return $query->rows;
    }
}
