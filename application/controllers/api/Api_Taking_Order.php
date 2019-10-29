<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_Taking_Order extends CI_Controller
{
    protected $date;
    protected $tabel = 'taking_order';
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
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
            $this->msg('', '400', '', 'tidak ada masukan');
        }
    }

    public function get_all()
    {
        $this->msg('data', '200', $this->Master->get_all($this->tabel, array("status !=" => "delete")));
    }

    public function get()
    {
        $this->is_valid();
        $id =  $this->input->post('id');
        $res = $this->Master->get($this->tabel, array('id' => $id));
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }


    public function upload_image()
    {
        $config['upload_path'] = './uploads/pegawai';
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
    function set_taking_order_booking()
    {
        $this->is_valid();
        $file_foto = $this->upload_image();
        $params = array(
            'cabang_id' => $this->input->post('cabang_id'),
            'barang_id' => $this->input->post('barang_id'),
            'customer_id' => $this->input->post('customer_id'),
            'qyt' => $this->input->post('qyt'),

            'status' => $this->input->post('status'),
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        );
        // if ($file_foto['status']) {
        // tr_id = kodecabang(3)_kodecustomer(4)_timestamp YYYYMMDD
        $params['tr_id'] = sprintf("%03d", $params['cabang_id']) . sprintf("%04d", $params['customer_id']) . date('Ymd');
        $params['data_barang'] = json_encode($this->get_data_barang());
        $params['data_customer'] = json_encode($this->get_data_customer());
        $params['total'] = (float) $params['qyt'] * (float) json_decode($params['data_barang'])->barang->harga;
        // var_dump($param['total']);
        $res = $this->Master->add($this->tabel, $params);
        if ($res['status']) {
            $res['data']['tr_id'] = $params['tr_id'];
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
        };
    }

    function set_taking_order_order()
    {
        $this->is_valid();
        $id =  $this->input->post('id');
        $data = array(
            'status' => 'order',
        );
        $res = $this->Master->update($this->tabel,  array('id' => $id), $data);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
        };
    }

    function get_data_barang()
    {
        $id =  $this->input->post('barang_id');
        $res = $this->Master->get('barang', array('id' => $id));
        if ($res['status']) {
            $data_barang['barang'] = $res['data'];
            if ($this->input->post('jenis_transaksi') == 'cuci_helm') {
                $file_foto = $this->upload_image();
                $data_barang['kondisi'] = json_decode($this->input->post('kondisi'));
                $data_barang['foto'] = $file_foto['name'];
                if ($file_foto['status']) {
                    return $data_barang;
                } else {
                    $this->msg('data', '400', '', $file_foto['error_msg']['img']);
                }
            } else {
                return $data_barang;
            }
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
        };
    }
    function get_data_customer()
    {
        $id =  $this->input->post('customer_id');
        $res = $this->Master->get('customer', array('id' => $id));
        if ($res['status']) {
            $data_customer['customer'] = $res['data'];
            $data_customer['barang'] = $this->get_data_barang();
            return $data_customer;
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
        };
    }
}
