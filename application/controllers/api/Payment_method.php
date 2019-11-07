<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_method extends CI_Controller
{
    protected $date;
    protected $tabel = 'payment_method';
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('Payment_model');
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


    function get_tunai(Type $var = null)
    {
        $res = $this->Master->get_select($this->tabel, $select, $where);
    }



    /*
     * Adding a new produk
     */
    function add()
    {
        $this->is_valid();
        $params = array(
            'tr_id' => $this->input->post('tr_id'),
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        );
        $data = $this->input->post('data');
        // var_dump($data);
        foreach ($data as $key => $value) {
            // var_dump($value);
            $this->add_action($key, $params, $value);
        }
        $this->msg('data', '200', array('tr_id' => $params['tr_id']));
    }

    function add_action($key, $params, $data)
    {
        $params['metode_pembayaran_id'] = $data['metode_pembayaran_id'];
        $params['diskon_id'] = $data['diskon_id'];
        $params['nominal'] = $data['nominal'];

        $detail_diskon = $this->Master->get_select('diskon', 'id,kode_diskon,nama,detail,mulai,akhir,potongan,kuota', array('id' => $params['diskon_id']));
        if ($detail_diskon['status'] && $params['diskon_id'] != 0) {
            $params['data_metode_pembayaran'] = json_encode(array('diskon' => $detail_diskon['data']));
        } else {
            $params['data_metode_pembayaran'] = json_encode(array('diskon' => NULL, 'keterangan' => json_decode($this->input->post('data_metode_pembayaran'))));
        }

        $res = $this->Master->add($this->tabel, $params);
        if ($res['status']) {
            return true;
            // $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
        };
    }

    function get_data_customer()
    {
        $id =  $this->input->post('customer_id');
        $res = $this->Master->get('customer', array('id' => $id));
        if ($res['status']) {
            $data['customer'] = $res['data'];
            return $data;
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
        };
    }
    function get_data_order()
    {
        $id =  $this->input->post('tr_id');
        $res = $this->Master->get_all('taking_order', array('tr_id' => $id));
        $data['total'] = 0.0;
        foreach ($res as $key => $value) {
            // var_dump($res[$key]["data_customer"]);
            $res[$key]["data_customer"] = json_decode($res[$key]["data_customer"]);
            $res[$key]["data_barang"] = json_decode($res[$key]["data_barang"]);
            $data['total'] += (float) $res[$key]["total"];
        }
        $data['taking_order'] = $res;
        // var_dump($data['total']);
        return $data;
    }
    function get_data_payment()
    {
        $id =  $this->input->post('tr_id');
        $res = $this->Master->get_all('payment_method', array('tr_id' => $id));
        $data['total'] = 0.0;
        foreach ($res as $key => $value) {
            $res[$key]["data_metode_pembayaran"] = json_decode($res[$key]["data_metode_pembayaran"]);
            $data['total'] += (float) $res[$key]["nominal"];
        }
        $data['payment_method'] = $res;
        return $data;
    }

    /*
     * Editing a produk
     */
    function edit()
    {
        $this->is_valid();
        // $this->msg('data', '200', $this->input->post('nama'));
        // check if the produk exists before trying to edit it
        $id =  $this->input->post('id');
        $data = array(
            'nama' => $this->input->post('nama'),
            'nomor' => $this->input->post('nomor'),
            'update_at' => date('Y-m-d H:i:s'),

        );
        $res = $this->Master->update($this->tabel,  array('id' => $id), $data);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
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
}
