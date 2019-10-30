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
            $data_order = json_decode(  $data[$key]['data_order']);
            $data[$key]['data_customer']=json_decode(  $data[$key]['data_customer'])->customer;
            // $data[$key]['data_order']=;
            $data[$key]['data_payment']=json_decode(  $data[$key]['data_payment']);
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
        $total_payment=$this->Payment_model->get_omset('payment','SUM(total) as total',array('create_at' => date('Y-m-d')),array('responsible_id'=>$id));
        $total_cash_flow=$this->Payment_model->get_omset('cash_flow','SUM(open_cash) as total',array('open' => date('Y-m-d')),array('responsible_id'=>$id));
        if ($total_payment&&$total_cash_flow) {
            $res['omset']=(float)$total_payment->total + (float)$total_cash_flow->total;
            $res['cash_register']=(float)$total_cash_flow->total;
        }else{
            $res['omset']="ERROR";
        }
        var_dump($res);
        $res['tunai'];
        $res['non_tunai'];
        $res['setoran_hari_ini'];
        $res = $this->Payment_model->get($this->tabel, array('tr_id' => $id));
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
        } else {
            $this->msg('data', '400', '', $res['data']['message']);
            // $this->msg('data', '400',$res);
        };
    }

    function get_tunai(Type $var = null)
    {
        $res=$this->Master->get_select($this->tabel, $select, $where);
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
        $params['data_payment'] = json_encode($this->get_data_payment());
        $params['total'] = json_decode($params['data_order'])->total;
        // var_dump(json_decode($params['data_payment'])->total);
        // var_dump(json_decode($params['data_order'])->total);
        if ((float)json_decode($params['data_payment'])->total<=(float)json_decode($params['data_order'])->total ) {
            $this->msg('data', '400', '', "belum lunas");
        }

        $res = $this->Master->add($this->tabel, $params);
        if ($res['status']) {
            $this->msg('data', '200', $res['data']);
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
        $data['total']=0.0;
        foreach ($res as $key => $value) {
            // var_dump($res[$key]["data_customer"]);
            $res[$key]["data_customer"]=json_decode($res[$key]["data_customer"]);
            $res[$key]["data_barang"]=json_decode($res[$key]["data_barang"]);
            $data['total']+=(float)$res[$key]["total"];
        }
        $data['taking_order'] = $res;
        // var_dump($data['total']);
        return $data;
    }
    function get_data_payment()
    {
        $id =  $this->input->post('tr_id');
        $res = $this->Master->get_all('payment_method', array('tr_id' => $id));
        $data['total']=0.0;
        foreach ($res as $key => $value) {
            $res[$key]["data_metode_pembayaran"]=json_decode($res[$key]["data_metode_pembayaran"]);
            $data['total']+=(float)$res[$key]["nominal"];
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
