<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MetodePembayaran extends CI_Controller
{
    protected $date;
    protected $tabel = 'metode_pembayaran';
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        // $this->load->model('user');
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


    public function get_all()
    {
        $data['metode_pembayaran'] = $this->Master->get_all($this->tabel);
        return $this->response([
            'error' => false,
            'message' => 'sukses',
            'data' => $data['metode_pembayaran']
        ]);
    }

    public function get()
    {
        $id =  $this->input->post('id');
        $metode_pembayaran = $this->Master->get($this->tabel, $id);
        if (isset($metode_pembayaran['id'])) {
            $this->msg('data', '204', $this->Master->get($this->tabel, $id));
        } else {
            $this->msg('data', '204', $this->Master->get($this->tabel, $id));
        }
    }



    /*
     * Adding a new metode_pembayaran
     */
    function add()
    {
        if (isset($_POST) && count($_POST) > 0) {
            $params = array(
                'nama' => $this->input->post('nama'), 'nomor' => $this->input->post('nomor'), 'create_at' => $this->date->getTimestamp(),
            );
            if ($this->Master->add($this->tabel, $params)) {
                $this->msg('data', '200', '');
            };
        } else {
            $this->msg('data', '404', '');
        }
    }

    /*
     * Editing a metode_pembayaran
     */
    function edit()
    {
        // check if the metode_pembayaran exists before trying to edit it
        $id =  $this->input->post('id');
        $data['metode_pembayaran'] = $this->Master->get($this->tabel, $id);
        if (isset($data['metode_pembayaran']['id'])) {
            if (isset($_POST) && count($_POST) > 0) {
                $params = array(
                    'nama' => $this->input->post('nama'),
                    'nomor' => $this->input->post('nomor'),
                );
                if ($this->Master->update($this->tabel, $id, $params)) {
                    $this->msg('data', '200', '');
                };
            } else {
                $this->msg('data', '400', '');
            }
        } else
            $this->msg('data', '404', '');
    }

    /*
     * Deleting metode_pembayaran
     */
    function remove()
    {
        $id =  $this->input->post('id');
        $metode_pembayaran = $this->Master->get($this->tabel, $id);

        // check if the metode_pembayaran exists before trying to delete it
        if (isset($metode_pembayaran['id'])) {
            if ($this->Master->delete($this->tabel, $id)) {
                $this->msg('data', '200', '');
            };
        } else
            $this->msg('data', '404', '');
    }
}
