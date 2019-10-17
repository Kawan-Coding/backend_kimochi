<?php

class Customer extends CI_Model
{
    //referense https://codeigniter.com/user_guide/general/models.html
    protected $users = 'pegawai';
    protected $cashflow = 'cash_flow';
    protected $date;
    public function __construct()
    {
        $this->date = new DateTime();
    }

    public function update($tabel,$where,$data)
    {
        $count = $this->db->get_where($tabel,$where)->row_array();
        $res = array();
        if (isset($count['id'])) {
            $this->db->where($where);
            $this->db->update($tabel,$data);
            if($this->db->affected_rows() != 1){
                $res['data']='tidak ada perubahan karena inputan sama';
                $res['status']=true;
            }else{
                $res['data']=$this->db->insert_id();
                $res['status']=true;
            }
        }else{
            $res['data']='data not exist';
            $res['status']=false;
        }

        return $res;

    }



    
}
