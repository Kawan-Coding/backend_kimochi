<?php

class User extends CI_Model
{

    protected $users = 'pegawai';
    protected $date;
    public function __construct()
    {
        $this->date = new DateTime();
    }

    public function save()
    {
        $data = array(
            "username" => $this->input->post("username"),
            "password" => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            "nama_lengkap" => $this->input->post("nama_lengkap"),
            "no_telepon" => $this->input->post("no_telepon"),
            "foto" => $this->input->post("foto"),
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
        $username    = $this->input->post('username');
        $password = $this->input->post('password');
        //mendapatkan password dari username diatas
        $hash = $this->get('username', $username)->password;
        // echo "$hash";

        if (password_verify($password, $hash)){
            return true;
        }else{
            return  false;
        }

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
}
