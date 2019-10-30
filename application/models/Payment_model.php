<?php

class Payment_model extends CI_Model
{
    //referense https://codeigniter.com/user_guide/general/models.html
    // function get_omset($like,$where)
    // {
    //     $this->db->select('SUM(total) as omset',FALSE);
    //     $this->db->from('payment');
    //     $this->db->like($like);
    //     $this->db->where($where);
    //     $this->db->group_by("responsible_id");
    //     $query =  $this->db->get();
    //     return $query->row();
    // }
    public function __construct()
    {
        $this->date = new DateTime();
    }
    function get_omset($tabel,$select,$like,$where)
    {
        $this->db->select($select,FALSE);
        $this->db->from($tabel);
        $this->db->like($like);
        $this->db->where($where);
        $this->db->group_by("responsible_id");
        $query =  $this->db->get();
        $res = $query->row();
        if ($res!=NULL) {
            return $res;
        }
    }

    function get_responsible($where)
    {
        $this->db->select('cabang.id,cabang.nama,	cabang.alamat,cabang.latlong');
        $this->db->select('responsible.id as id_responsible,responsible.role');
        $this->db->order_by('close', 'DESC');
        $this->db->from('cash_flow');
        $this->db->join('responsible', 'responsible.id = cash_flow.responsible_id');
        $this->db->join('pegawai', 'pegawai.id = responsible.pegawai_id');
        $this->db->join('cabang', 'cabang.id = responsible.cabang_id');
        $this->db->where('pegawai.username', $this->input->post("username"));
        $query =  $this->db->get();
        return $query->row();
    }
}
