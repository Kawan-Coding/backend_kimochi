<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Allowed_payment extends CI_Controller
{
    protected $date;
    protected $tabel = 'allowed_payment';
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('Allowed_payment_model');
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
        $result = array();
        foreach ($data as $element) {
            $result[$element['cabang_id']][] = $element;
        }
        $this->msg('data', '200', $this->_group_by($result));
    }
    public function get_where_cabang_id()
    {
        $cabang_id = $this->input->post('cabang_id');
        $data = $this->Allowed_payment_model->get_where_cabang_id($cabang_id);
        // $result = array();
        // foreach ($data as $element) {
        //     $result[$element['cabang_id']][] = $element;
        // }
        $this->msg('data', '200', $data);
    }
    function _group_by($array)
    {
        $return = array();
        foreach ($array as $val) {
            $return[] = $val;
        }
        return $return;
    }

    public function get()
    {
        $data = $this->Master->get_all($this->tabel, array('cabang_id' => $this->input->post('cabang_id')));
        // var_dump($data);
        $result = array();
        foreach ($data as $element) {
            $result[$element['cabang_id']][] = $element;
        }

        $this->msg('data', '200', $this->_group_by($result));
    }


    function add()
    {

        $arr_metode_pembayaran_id = $this->input->post('metode_pembayaran_id');
        // var_dump($arr_metode_pembayaran_id);
        // var_dump($this->input->post('cabang_id'));
        if (!empty($arr_metode_pembayaran_id)) {
            foreach ($arr_metode_pembayaran_id as $key => $value) {
                $data = array(
                    'cabang_id' => $this->input->post('cabang_id'),
                    'metode_pembayaran_id' => $value
                );
                $res = $this->Master->add($this->tabel,  $data);
                if (!$res['status']) {
                    $this->msg('data', '400', '', $res['data']['message']);
                }
            }
            if ($res['status']) {
                $this->msg('data', '200', $res['data']);
            }
        } else {
            $this->msg('data', '400', '', 'mohon memasukkan metode pembayaran');
        }
    }

    /*
     * Editing a produk
     */
    function edit()
    {
        $this->is_valid();
        $arr_metode_pembayaran_id = $this->input->post('metode_pembayaran_id');
        // $this->msg('data', '200', $this->input->post('nama'));
        // check if the produk exists before trying to edit it
        $id =  $this->input->post('id');
        $res = '';
        if (!empty($arr_metode_pembayaran_id)) {
            $this->remove(true);
            foreach ($arr_metode_pembayaran_id as $key => $value) {
                $data = array(
                    'cabang_id' => $this->input->post('cabang_id'),
                    'metode_pembayaran_id' => $value
                );
                // var_dump($data);
                $res = $this->Master->add($this->tabel,  $data);
                if (!$res['status']) {
                    $this->msg('data', '400', '', $res['data']['message']);
                }
            }
            if ($res['status']) {
                $this->msg('data', '200', $res['data']);
            }
        } else {
            $this->msg('data', '400', '', 'mohon memasukkan metode pembayaran');
        }
    }

    /*
     * Deleting produk
     */
    function remove($edit = false)
    {
        $this->is_valid();
        $cabang_id =  $this->input->post('cabang_id');
        $res = $this->Master->delete($this->tabel, array('cabang_id' => $cabang_id), 'cabang_id');
        if ($edit) {
            return $res['status'];
        } else {
            if ($res['status']) {
                $this->msg('data', '200', $res['data']);
            } else {
                $this->msg('data', '400', '', $cabang_id . "delete " . $res['data']['message']);
            };
        }
    }
}
