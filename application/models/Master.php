<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    //THE MASTER OF THE MASTER
    /*
     * Get allowed_payment by id
     */
    public function get($tabel,$where)
    {
        $run = $this->db->get_where($tabel,$where)->row_array();
        $res = array();
        if (!isset($run)) {
            $res['data']='data not exist';
            $res['status']=false;
        } else {
            $res['data']=$run;
            $res['status']=true;
        }
        return $res;
    }
    public function get_select($tabel,$select,$where)
    {
        $this->db->select($select);
        $run = $this->db->get_where($tabel,$where)->row_array();
        $res = array();
        if (!isset($run)) {
            $res['data']='data not exist';
            $res['status']=false;
        } else {
            $res['data']=$run;
            $res['status']=true;
        }
        return $res;
    }
        
    /*
     * Get all allowed_payment
     */
    public function get_all($tabel)
    {
        return $this->db->get($tabel)->result_array();
    }
        
    /*
     * public function untuk add new allowed_payment
     */
    public function add($tabel,$data)
    {
        $this->db->insert($tabel,$data);
        $res = array();
        if($this->db->affected_rows() != 1){
            $res['data']=$this->db->error();
            $res['status']=false;
        }else{
            $res['data']=array('id'=>$this->db->insert_id());
            $res['status']=true;
        }
        return $res;
    }
    
    /*
     * public function untuk update allowed_payment
     */
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
    
    /*
     * public function untuk delete allowed_payment
     */
    public function delete($tabel,$where)
    {
        $count = $this->db->get_where($tabel,$where)->row_array();
        $res = array();
        if (isset($count['id'])) {
            $this->db->delete($tabel,$where);
            if($this->db->affected_rows() != 1){
                $res['data']=$this->db->error();
                $res['status']=false;
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