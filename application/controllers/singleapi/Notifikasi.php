<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{
    protected $date;
    protected $tabel = 'notifikasi';
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('Produk');
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
            $this->msg('data', '400', '',$res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }


    public function upload_image()
    {
        $config['upload_path'] = './uploads/notifikasi';
        $config['allowed_types'] = 'gif|jpg|png|JPG';
        $config['encrypt_name'] = true;
        // $config['max_size'] = 600;
        // $config['max_width'] = 1024;
        // $config['max_height'] = 768;
        $this->load->library('upload', $config);
        $is_upload_succces = $this->upload->do_upload('foto');
        $file = $this->upload->data();
        $error_upload = array('img' => $this->upload->display_errors());
        return array('status' => $is_upload_succces, 'name' => $file['file_name'], 'error_msg' => $error_upload);
    }
    /*
     * Adding a new produk
     */
    function add()
    {
        $this->is_valid();
        $file_foto = $this->upload_image();
        $params = array(
            'jenis_konten' => $this->input->post('jenis_konten'),
            'judul' => $this->input->post('judul'),
            'detail' => $this->input->post('detail'),
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        );
        if ($file_foto['status']) {
            $params['foto'] = $file_foto['name'];
            $res = $this->Master->add($this->tabel, $params);
            if ($res['status']) {
                $this->msg('data', '200', $res['data']);
            } else {
                $this->msg('data', '400', '',$res['data']['message']);
            };
        } else {
            $this->msg('data', '400','', $file_foto['error_msg']['img']);
        }
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
            'jenis_konten' => $this->input->post('jenis_konten'),
            'judul' => $this->input->post('judul'),
            'detail' => $this->input->post('detail'),
            'update_at' => date('Y-m-d H:i:s'),
        );
        if (!empty($_FILES['foto']['name'])) {
            $file_foto = $this->upload_image();
            $data['foto'] = $file_foto['name'];
            if ($file_foto['status']) {
                $res = $this->Master->update($this->tabel,  array('id' => $id), $data);
                if ($res['status']) {
                    $this->msg('data', '200', $res['data']);
                } else {
                    $this->msg('data', '400','', $res['data']['message']);
                };
            } else {
                $this->msg('data', '400','', $file_foto['error_msg']['img']);
            }
        } else {
            // unset($params['foto']);
            $res = $this->Master->update($this->tabel,  array('id' => $id), $data);
            if ($res['status']) {
                $this->msg('data', '200', $res['data']);
            } else {
                $this->msg('data', '400','', $res['data']['message']);
            };
        }
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
            $this->msg('data', '400', '',$res['data']['message']);
        };
    }
}
