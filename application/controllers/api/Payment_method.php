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
        $this->load->model('Payment_method_model');
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
    public function get_all()
    {
        $this->msg('data', '200', $this->Master->get_all($this->tabel));
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
        //CEK KIMOCHI PAYMENT DARI CUSTOMER CUKUP APA ENGGA
        $id_post_kimochi_payment = $this->get_id_kimochi_wallet($data);
        $kimochi_wallet_customer = $this->Payment_method_model->get_kimochi_wallet($params['tr_id']);
        if ($data[$id_post_kimochi_payment]['nominal'] > $kimochi_wallet_customer->kimochi_wallet) {
            $this->msg('data', '400', '', 'tidak bisa menggunakan kimochi wallet, saldo tidak cukup' . " | data index $id_post_kimochi_payment | saldo $kimochi_wallet_customer->kimochi_wallet");
        } else {
            $tmp_dt_update = array(
                'kimochi_wallet' => $kimochi_wallet_customer->kimochi_wallet - $data[$id_post_kimochi_payment]['nominal'],
            );
            $update_kimochi_customer = $this->Master->update('customer',  array('id' => $kimochi_wallet_customer->id), $tmp_dt_update);
            if (!$update_kimochi_customer['status']) {
                $this->msg('data', '400', '', $update_kimochi_customer['data']['message']);
            }
        }

        // $this->msg('data', '200', );

        foreach ($data as $key => $value) {
            // var_dump($value);
            $this->add_action($id_post_kimochi_payment, $params, $value,$key);
        }
        $kimochi_wallet_customer = $this->Payment_method_model->get_kimochi_wallet($params['tr_id']);
        $this->msg('data', '200', array('tr_id' => $params['tr_id'], 'kimochi_payment' => $kimochi_wallet_customer->kimochi_wallet));
    }

    function get_id_kimochi_wallet($data)
    {
        $id_kimochi_wallet = $this->Master->get('metode_pembayaran', array("jenis" => 'kw'), 'id')['data']['id'];
        foreach ($data as $key => $value) {
            if ($value['metode_pembayaran_id'] == $id_kimochi_wallet) {
                return $key;
            }
        }
        return null;
    }

    function add_action($kimochi_wallet_id, $params, $data,$key)
    {
        $params['metode_pembayaran_id'] = $data['metode_pembayaran_id'];
        $params['diskon_id'] = $data['diskon_id'];
        $params['nominal'] = $data['nominal'];

        $detail_diskon = $this->Master->get_select('diskon', 'id,kode_diskon,nama,detail,mulai,akhir,potongan,kuota', array('id' => $params['diskon_id']));
        if ($detail_diskon['status'] && $params['diskon_id'] != 0) {
            $params['data_metode_pembayaran'] = json_encode(array('diskon' => $detail_diskon['data']));
        } else {
            // var_dump($kimochi_wallet_id) ;
            if ($kimochi_wallet_id == $key) {
                $tmp_arr = array('media'=>'kimochi_wallet');
                $params['data_metode_pembayaran'] = json_encode(array('diskon' => NULL, 'keterangan' => $tmp_arr));
            } else {
                $params['data_metode_pembayaran'] = json_encode(array('diskon' => NULL, 'keterangan' => json_decode($data['data_metode_pembayaran'])));
            }
        }

        $res = $this->Master->add($this->tabel, $params);
        if ($res['status']) {
            return true;
            // $this->msg('data', '200', $res['data']);
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
