<?php

class Payment_method_model extends CI_Model
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

    function get_kimochi_wallet($tr_id)
    {
        $this->db->select('c.kimochi_wallet,c.id');
        // $this->db->select('responsible.id as id_responsible,responsible.role');
        // $this->db->order_by('close', 'DESC');
        $this->db->from('taking_order as to');
        $this->db->join('customer as c', 'c.id = to.customer_id');
        $this->db->where('to.tr_id',$tr_id);
        $query =  $this->db->get();
        return $query->row();
    }
}
