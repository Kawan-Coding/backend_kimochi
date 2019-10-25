<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_Get extends CI_Controller
{
    protected $date;
    // protected $tabel = 'metode_pembayaran';
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
        $this->msg('data', '200', $this->Master->get_all($this->tabel));
    }

    public function get_data_booking_where_status_booking()
    {
        $res = $this->Master->get('taking_order', array('status' => 'booking'));
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }

    public function get_data_barang()
    {
        $res = $this->Master->get_all('barang');
        $this->msg('data', '200', $this->Master->get_all('barang'));
    }
    public function get_detail_barang()
    {
        $res = $this->Master->get_all('barang');
        $this->msg('data', '200', $this->Master->get_all('barang'));
    }
    public function get_detail_aksesoris()
    {
        $id =  $this->input->post('id');
        $res = $this->Master->get('barang', array('id' => $id));
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }
    public function get_transaksi()
    {
        $el = $this->Master->get_all('taking_order', '',array('tr_id','DESC'));
        // foreach ($el as $res) {
        //     $res['data_customer']=json_decode($res['data_customer']);
        //     $res['data_customer']['barang']['kondisi']=json_decode($res['data_customer']['barang']['kondisi']);
        //     $res['data_barang']=json_decode($res['data_barang']);
        // }
        $this->msg('data', '200', $el);
    }
}
