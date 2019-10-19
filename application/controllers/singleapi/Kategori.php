<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    protected $date;
    protected $tabel = 'kategori';
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        // $this->load->model('Produk');
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
            $this->msg('', '400', '');
        }
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
            $this->msg('data', '500', $res['data']);
            // $this->msg('data', '500',$res);
        };
    }



    /*
     * Adding a new produk
     */
    function add()
    {
        $this->is_valid();
        $params = array(
            'jenis_id' => $this->input->post('jenis_id'),
            'kategori_id' => $this->input->post('kategori_id'),
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga'),
            'create_at' => date('Y-m-d H:i:s'),
            'detail' => $this->input->post('detail'),
            'foto' => $this->input->post('foto')
        );
        
        $res = $this->Master->add($this->tabel, $params);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '500', $res['data']);
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
            'jenis_id' => $this->input->post('jenis_id'),
            'kategori_id' => $this->input->post('kategori_id'),
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga'),
            'detail' => $this->input->post('detail'),
            'foto' => $this->input->post('foto'),
        );
        $res = $this->Master->update($this->tabel,  array('id' => $id), $data);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '500', $res['data']);
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
            $this->msg('data', '500', $res['data']);
        };
    }
}
