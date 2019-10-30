<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
    protected $date;
    protected $tabel = 'payment';
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

    public function get_all()
    {
        $data = $this->Master->get_all($this->tabel);
        foreach ($data as $key => $value) {
            $data_order = json_decode($data[$key]['data_order']);
            $data[$key]['data_customer'] = json_decode($data[$key]['data_customer'])->customer;
            // $data[$key]['data_order']=;
            $data[$key]['data_payment'] = json_decode($data[$key]['data_payment']);
        }
        $this->msg('data', '200', $data);
    }

    public function get()
    {
        $this->is_valid();
        $id =  $this->input->post('tr_id');
        $res = $this->Master->get($this->tabel, array('tr_id' => $id));
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }

    public function get_setoran_hari_ini()
    {
        $this->is_valid();
        $id =  $this->input->post('responsible_id');
        $arr_sum = $this->Payment_model->get_sum('payment', 'sum(total) as total,sum(total_payment) as total_payment,sum(tunai) as tunai,sum(non_tunai) as non_tunai,sum(potongan) as potongan', array('create_at' => date('Y-m-d')), array('responsible_id' => $id));
        // $this->msg('data', '200', $arr_sum->total_payment);
        $total_cash_flow = $this->Payment_model->get_sum('cash_flow', 'SUM(open_cash) as total', array('open' => date('Y-m-d')), array('responsible_id' => $id));
        if ($arr_sum->total_payment && $total_cash_flow) {
            $res['omset'] = (float) $arr_sum->total_payment + (float) $total_cash_flow->total;
            $res['cash_register'] = (float) $total_cash_flow->total;
        } else {
            $res['omset'] = "ERROR";
        }
        $res['tunai'] = $arr_sum->tunai;
        $res['non_tunai'] = $arr_sum->non_tunai;
        $res['setoran_hari_ini'] = $res['cash_register'] + $res['tunai'];
        // var_dump($res);
        $this->msg('data', '200', $res);
    }

    function get_sum_jenis($data)
    {
    }



    /*
     * Adding a new produk
     */
    function add()
    {
        $this->is_valid();
        $params = array(
            'tr_id' => $this->input->post('tr_id'),
            'cabang_id' => $this->input->post('cabang_id'),
            'customer_id' => $this->input->post('customer_id'),
            'responsible_id' => $this->input->post('responsible_id'),

            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        );
        $params['data_customer'] = json_encode($this->get_data_customer());
        $params['data_order'] = json_encode($this->get_data_order());
        $data_payment = $this->get_data_payment();
        // $this->msg('data', '200', $data_payment);
        $params['data_payment'] = json_encode($data_payment['payment_method']);

        $params['total'] = $data_payment['total'];//masukan aja
        $params['total_payment'] = $data_payment['total_payment'];//masukan + diskon
        $params['tunai'] = $data_payment['tunai'];
        $params['non_tunai'] = $data_payment['non_tunai'];
        $params['potongan'] = $data_payment['potongan'];
        // var_dump(json_decode($params['data_payment'])->total);
        // var_dump(json_decode($params['data_order'])->total);
        $bayar = (float) $params['total_payment'];
        $tagihan = (float) json_decode($params['data_order'])->total;

        if ($bayar < $tagihan) {
            $this->msg('data', '400', array('bayar' => $bayar, 'tagihan' => $tagihan), "belum lunas");
        }

        $res = $this->Master->add($this->tabel, $params);

        if ($res['status']) {
            $update_status_taking_order = $this->Master->update('taking_order', array('tr_id' => $params['tr_id']), array('status' => 'paid'));
            if ($update_status_taking_order['status']) {
                $this->msg('data', '200', array('tr_id' => $params['tr_id']));
            } else {
                $this->msg('data', '400', $params['tr_id'], 'update taking order gagal');
            }
        } else {
            $this->msg('data', '400', $params['tr_id'], $res['data']['message']);
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
        $res = $this->Master->get_all('taking_order', array('tr_id' => $id), '', array('id AS taking_order_id', 'cabang_id', 'barang_id', 'data_barang', 'qyt', 'total', 'create_at', 'update_at'));
        $data['total'] = 0.0;
        foreach ($res as $key => $value) {
            // var_dump($res[$key]["data_customer"]);
            // $res[$key]["data_customer"]=json_decode($res[$key]["data_customer"]);
            $res[$key]["data_barang"] = json_decode($res[$key]["data_barang"])->barang;
            $data['total'] += (float) $res[$key]["total"];
        }
        $data['taking_order'] = $res;
        // var_dump($data['total']);
        return $data;
    }

    function in_array($str, $data)
    {

        foreach ($data as $key => $value) {
            if ($str == $value['id']) {
                return TRUE;
            }
        }
        return FALSE;
    }
    function get_data_payment()
    {
        $id =  $this->input->post('tr_id');
        $res = $this->Master->get_all('payment_method', array('tr_id' => $id));
        $id_potongan = $this->Master->get_all('metode_pembayaran', array("jenis" => 'potongan'), '', 'id');
        $id_tunai = $this->Master->get_all('metode_pembayaran', array("jenis" => 'tunai'), '', 'id');
        $id_non_tunai = $this->Master->get_all('metode_pembayaran', array("jenis" => 'non tunai'), '', 'id');
        // var_dump( $id_non_tunai);
        $data['total'] = 0.0;//masukan aja
        $data['total_payment'] = 0.0;//diskon + masukan
        $data['tunai'] = 0.0;
        $data['non_tunai'] = 0.0;
        $data['potongan'] = 0.0;

        foreach ($res as $key => $value) {
            $res[$key]["data_metode_pembayaran"] = json_decode($res[$key]["data_metode_pembayaran"]);

            if (!$this->in_array($value['metode_pembayaran_id'], $id_potongan)) {
                $data['total'] += (float) $res[$key]["nominal"];
            } else {
                $data['potongan'] += (float) $res[$key]["nominal"];
            }
            $data['tunai'] += $this->in_array($value['metode_pembayaran_id'], $id_tunai) ? (float) $res[$key]["nominal"] : 0.0;
            $data['non_tunai'] += $this->in_array($value['metode_pembayaran_id'], $id_non_tunai) ? (float) $res[$key]["nominal"] : 0.0;


            $data['total_payment'] += (float) $res[$key]["nominal"];
        }
        $data['payment_method'] = $res;
        // $this->msg('data', '200', $data);
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
