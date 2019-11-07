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

    function get_dt_for_omset($tabel, $like, $where)
    {
        if ($where != '') {
            $this->db->where($where);
        }
        if ($like != '') {
            $this->db->like($like);
        }
        $this->db->select('', FALSE);
        $this->db->from('payment as p');
        $this->db->join('payment_met as p', 'pm.tr_id = p.tr_id', 'right');

    }
    function get_sum($tabel, $select, $like, $where='')
    {
        $this->db->select($select, FALSE);
        $this->db->select('pgw.username,CAST(p.create_at AS DATE) as create_at,c.nama', FALSE);
        $this->db->from($tabel);
        $this->db->like($like);
        if ($where!='') {
            $this->db->where($where);
        }
        $this->db->join('responsible as r', 'r.id = p.responsible_id');
        $this->db->join('pegawai as pgw', 'pgw.id = r.pegawai_id');
        $this->db->join('cabang as c', 'c.id = p.cabang_id');
        $this->db->group_by("responsible_id");
        $query =  $this->db->get();
        $res = $query->row();
        if ($res != NULL) {
            return $res;
        }
    }
    function get_history_transaksi($day, $where)
    {
        $this->db->select('sum(pm.nominal) as total', FALSE);
        $this->db->select('mp.nama,mp.id as metode_pembayaran_id');
        $this->db->from('payment_method as pm');
        $this->db->like('p.create_at', $day);
        $this->db->where($where);
        $this->db->join('payment as p', 'pm.tr_id = p.tr_id', 'right');
        $this->db->join('metode_pembayaran as mp', 'mp.id = pm.metode_pembayaran_id', 'full');
        $this->db->group_by("mp.nama");
        $query =  $this->db->get();
        $res = $query->result_array();
        if ($res != NULL) {
            return $res;
        }
    }

    function get_transaksi_hari_ini_bank($day, $where)
    {
        $this->db->select('pm.tr_id');
        $this->db->select('mp.nama,pm.nominal');
        $this->db->from('payment as p');
        $this->db->like('p.create_at', $day);
        $this->db->join('payment_method as pm', 'pm.tr_id = p.tr_id', 'right');
        $this->db->join('metode_pembayaran as mp', 'mp.id = pm.metode_pembayaran_id');
        $this->db->group_by('metode_pembayaran_id', 'tr_id');
        $this->db->where($where);
        $query =  $this->db->get();
        $res = $query->result_array();
        if ($res != NULL) {
            return $res;
        }
    }
    public function get_payment_method($tabel, $where = '')
    {
        $this->db->select('pm.nominal');
        $this->db->select('mp.nama,mp.id');
        $this->db->from('payment_method as pm');
        $this->db->join('metode_pembayaran as mp', 'mp.id = pm.metode_pembayaran_id', 'right');
        $this->db->group_by('mp.id');
        $this->db->where($where);
        $query =  $this->db->get();
        $res = $query->result_array();
        if ($res != NULL) {
            return $res;
        }
    }



    // function get_sum($where,$like)
    // {
    //     $this->db->like($like);
    //     $this->db->where($where);
    // }

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
