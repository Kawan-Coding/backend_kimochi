<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    protected $date;
    protected $tabel = 'customer';
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        // $this->load->model('Customer');
        $this->date = new DateTime();
        // $this->load->library('Msg');
        //==== ALLOWING CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    }
    public function msg($name, $status, $data, $custom_msg = '')
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($this->msg->get($name, $status, $data, $custom_msg), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    function is_valid()
    {
        if (isset($_POST) && count($_POST) <= 0) {
            $this->msg('', '400', '','tidak ada masukan');        }
    }

    public function get_all()
    {
        $this->msg('data', '200', $this->Master->get_all($this->tabel));
    }

    public function get()
    {
        $this->is_valid();
        $id =  $this->input->post('id');
        $res = $this->Master->get($this->tabel, array('id' => $id));
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400','', $res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }



    /*
     * Adding a new produk
     */
    function add()
    {
        $this->is_valid();
        $params = array(
            'password' => password_hash($this->input->post['password'], PASSWORD_DEFAULT),
            'username' => $this->input->post('username'),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'no_telepon' => $this->input->post('no_telepon'),
            'kendaraan' => $this->input->post('kendaraan'),
            'plat_nomor' => $this->input->post('plat_nomor'),
            'member' => $this->input->post('member'),
            'create_at' => date('Y-m-d H:i:s'),
            // 'update_at' => $this->input->post('update_at'),
            'foto' => $this->input->post('foto'),
        );

        $res = $this->Master->add($this->tabel, $params);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400','', $res['data']['message']);
        };
    }

    /*
     * Editing a produk
     */
    function edit()
    {
        $this->is_valid();
        // check if the produk exists before trying to edit it
        $id =  $this->input->post('id');
        $data = array(
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'username' => $this->input->post('username'),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'no_telepon' => $this->input->post('no_telepon'),
            'kendaraan' => $this->input->post('kendaraan'),
            'plat_nomor' => $this->input->post('plat_nomor'),
            'member' => $this->input->post('member'),
            'update_at' => date('Y-m-d H:i:s'),
            // 'create_at' => date('Y-m-d H:i:s'),
            'foto' => $this->input->post('foto'),
        );
        $res = $this->Master->update($this->tabel,  array('id' => $id), $data);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400','', $res['data']['message']);
        };
    }

    /*
     * Deleting produk
     */
    function remove()
    {
        $this->is_valid();
        $id =  $this->input->post('id');
        $res = $this->Master->delete($this->tabel, array('id' => $id));

        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
        };
    }

    public function getByNumber()
    {
        $this->is_valid();
        $no_telepon =  $this->input->post('no_telepon');
        $res = $this->Master->get($this->tabel, array('no_telepon' => $no_telepon));
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }

    function updatePass()
    {
        $this->is_valid();
        // check if the produk exists before trying to edit it
        $id =  $this->input->post('id');
        $data = array(
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        );
        $res = $this->Master->update($this->tabel,  array('id' => $id), $data);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400','', $res['data']['message']);
        };
    }

    public function updateUserPassByNoTelp()
    {
        $this->is_valid();
        // check if the produk exists before trying to edit it
        $no_telepon =  $this->input->post('no_telepon');
        $data = array(
            'username' => $this->input->post('username'),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        );
        $res = $this->Master->update($this->tabel,  array('no_telepon' => $no_telepon), $data);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
        };
    }
}
