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
    public function get($tabel,$id)
    {
        return $this->db->get_where($tabel,array('id'=>$id))->row_array();
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
        return $this->db->insert_id();
    }
    
    /*
     * public function untuk update allowed_payment
     */
    public function update($tabel,$id,$data)
    {
        $this->db->where('id',$id);
        return $this->db->update($tabel,$data);
    }
    
    /*
     * public function untuk delete allowed_payment
     */
    public function delete($tabel,$id)
    {
        return $this->db->delete($tabel,array('id'=>$id));
    }
    
    
}