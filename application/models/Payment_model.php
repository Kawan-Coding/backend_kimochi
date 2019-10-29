<?php

class Payment_model extends CI_Model
{
    //referense https://codeigniter.com/user_guide/general/models.html

    public function __construct()
    {
        $this->date = new DateTime();
    }

    public function save()
    {
        $data = array(
            "username" => $_POST['username'],
            "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
            "nama_lengkap" => $_POST['nama_lengkap'],
            "no_telepon" => $_POST['no_telepon'],
            "foto" => $_POST['foto'],
            "create_at" => $this->date->getTimestamp()

        );
        if ($this->isUser_exists($data['username']) > 0) {
            return [
                'error' => true,
                'message' => 'username tidak tersedia',
                'data' => ''
            ];
        } elseif ($this->db->insert($this->users, $data)) {
            return [
                'error' => false,
                'message' => 'data behasil dimasukkan',
                'data' => ''
            ];
        } else {
            return [
                'error' => true,
                'message' => $this->db->error(),
                'data' => ''
            ];
        }
    }

    public function get($key = null, $value = null)
    {
        if ($key != null) {
            $query = $this->db->get_where($this->users, array($key => $value));
            return $query->row();
        }

        $query = $this->db->get($this->users);
        return $query->result();
    }

    public function is_valid()
    {
        $username    = $_POST['username'];
        $password = $_POST['password'];
        $count = $this->db->get_where($this->users, array('username' => $username))->row_array();
        //mendapatkan password dari username diatas
        if (isset($count['id'])) {
            $hash = $this->get('username', $username)->password;
            if (password_verify($password, $hash)) {
                return true;
            } else {
                return  false;
            }
        } else {
            return false;
        }


        // echo "$hash";



    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->users)) {
            return [
                'error' => false,
                'message' => 'data behasil dihapus'
            ];
        }
    }

    public function update($id, $data)
    {
        $data = ['email' => $data->email];

        $this->db->where('id', $id);
        if ($this->db->update($this->users, $data)) {
            return [
                'error' => false,
                'message' => 'data behasil diupdate'
            ];
        }
    }

    function isUser_exists($username)
    {
        $this->db->where('username', $username);
        return $this->db->count_all_results($this->users);
    }

    function get_status_last_cashflow()
    {
        $this->db->select('cash_flow.status');
        $this->db->order_by('close', 'DESC');
        $this->db->from('cash_flow');
        $this->db->join('responsible', 'responsible.id = cash_flow.responsible_id');
        $this->db->join('pegawai', 'pegawai.id = responsible.pegawai_id');
        $this->db->where('pegawai.username', $this->input->post("username"));
        $query =  $this->db->get();
        return $query->row();
    }

    function get_responsible()
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
