<?php

class Customer_model extends CI_Model
{
    //referense https://codeigniter.com/user_guide/general/models.html
    protected $users = 'pegawai';
    protected $cashflow = 'cash_flow';
    protected $date;
    public function __construct()
    {
        parent::__construct();
        $this->date = new DateTime();
    }
    function get_count_transaction($id_c)
    {
        $this->db->select('count(tr_id) AS c');
        $this->db->where('customer_id',$id_c);
        $this->db->group_by('customer_id');
        return $this->db->get('payment')->row();
    }


    
}
