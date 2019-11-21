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
        $this->load->model('Api_get_model');
        $this->date = new DateTime();
        // $config['allow_get_array'] = TRUE;
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
        $res['data']['data_customer'] = json_decode($res['data']['data_customer']);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }

    public function get_data_barang()
    {
        $tr_id = $this->input->post('tr_id');
        if (!empty($tr_id)) {

            $to = $this->Master->get('taking_order', ['tr_id' => $tr_id], ['data_barang', 'qyt'], TRUE);
            if (!$to['status']) {
                $this->msg('data', '400', '', $to['data']['message']);
                // $str_msg = 'query berhasil [TR ID tidak ada'
                // $to = null;
            }
        } else {
            $to = null;
        }
        $res = $this->Api_get_model->get_data_barang();
        // var_dump($res);
        foreach ($res as $key => $value) {
            if ($value['kategori_id'] == '1') {
                // var_dump( array_merge($value, $this->get_from_to($to, $value, $res, TRUE)));
                $data['cuci_helm'][] = array_merge($value, $this->get_from_to($to, $value, $res, TRUE));
            } else if ($value['kategori_id'] == '2') {
                $data['aksesoris'][] = array_merge($value, $this->get_from_to($to, $value, $res, FALSE));
            }
        }
        $this->msg('data', '200', $data);
    }

    function get_from_to($to, $barang, $barangAll, $ch = false)
    {
        $tmp= array();
        $tmp['kondisi']=0;
        $tmp['foto_helm']=0;
        // echo"hi";
        if ($to != NULL) {
            foreach ($to['data'] as $key => $ito) {
                foreach ($barangAll as $key => $ibarang) {
                    $to_id_barang = json_decode($ito['data_barang'])->barang->produk_id;
                    if ($barang['produk_id'] == $to_id_barang) {
                        $tmp['qyt'] = $ito['qyt'];
                        $dt_barang = json_decode($ito['data_barang'], TRUE);
                        if ($ch) {
                            $tmp['kondisi'] = $dt_barang['kondisi'];
                            $tmp['foto_helm'] = $dt_barang['foto_helm'];
                        }
                        // var_dump($tmp);
                        return ($tmp);
                    }
                }
            }
        }
        return $tmp;
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
    public function get_transaksi_booking()
    {
        $cabang_id = $this->input->post('cabang_id');
        $el = $this->Master->get_all('taking_order', array('status' => 'booking', 'cabang_id' => $cabang_id), array('tr_id', 'DESC'), 'id as taking_order_id,tr_id,data_customer,customer_id,status,status_produksi,create_at as jam_order', '', TRUE, 'tr_id');
        foreach ($el as $key => $value) {
            $el[$key]['data_customer'] = json_decode($value['data_customer'])->customer;
            $el[$key]['jam_order'] = date('d F Y H:i:s', strtotime($value['jam_order']));
        }
        $this->msg('data', '200', $el);
    }
    public function get_transaksi_order()
    {
        $cabang_id = $this->input->post('cabang_id');
        $el = $this->Master->get_all('taking_order', array('status !=' => 'booking', 'cabang_id' => $cabang_id), array('status', 'ASC'), 'id as taking_order_id,tr_id,data_customer,customer_id,status,status_produksi,create_at as jam_order', '', TRUE, 'tr_id');
        foreach ($el as $key => $value) {
            $el[$key]['data_customer'] = json_decode($value['data_customer'])->customer;
            $el[$key]['status'] = $el[$key]['status'] == 'order' ? 'unpaid' : 'paid';
            $el[$key]['jam_order'] = date('d F Y H:i:s', strtotime($value['jam_order']));
        }
        $this->msg('data', '200', $el);
    }
}
