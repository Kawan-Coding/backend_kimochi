<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CashRegisterController     extends CI_Controller
{
    protected $date;
    protected $tabel = 'cash_flow';
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        // $this->load->model('user');
        // $this->date = new DateTime();
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


    /*
     * Adding a new metode_pembayaran
     */
    function open()
    {
        if (isset($_POST) && count($_POST) > 0) {
            $params = array(
                'responsible_id' => $this->input->post('responsible_id'),
                'open' => date('Y-m-d H:i:s'),
                'open_cash' => $this->input->post('open_cash'),
                'data_pegawai' => $this->input->post('data_pegawai'),
                'status' => 'progress',
            );
            $run = $this->Master->add($this->tabel, $params);
            if ($run['status']) {
                $this->msg('data', '200', $run['data']);
            } else {
                $this->msg('data', '400', '', $run['data']);
                // $this->msg('data', '400',$run);
            };
        } else {
            $this->msg('data', '404', '');
        }
    }

    /*
     * Editing a metode_pembayaran
     */
    function close()
    {
        $id = $_POST['id'];
        if (isset($_POST) && count($_POST) > 0) {
            $params = array(
                'close' => date('Y-m-d H:i:s'),
                'close_cash' => $this->input->post('close_cash'),
                'status' => 'unvalidated',
            );
            $is_progress =  $this->Master->get_select($this->tabel, array('status'), array('id' => $id));

            if ($is_progress['data']['status'] == 'progress') {
                $run = $this->Master->update($this->tabel, array('id' => $id), $params);
                $this->msg('data', '200', $run['data']);
                if ($run['status']) {
                    $this->msg('data', '200', $run['data']);
                } else {
                    $this->msg('data', '400', '', $run['data']);
                    // $this->msg('data', '400',$run);
                };
            } else {
                $this->msg('data', '300','', 'Anda tidak dapat melakukan close register. Anda harus open register terlebih dahulu' . $is_progress['data']['status']);
            }
        } else {
            $this->msg('data', '400', '');
        }
    }

    /*
     * Deleting metode_pembayaran
     */
    function remove()
    {
        $id =  $this->input->post('id');
        $metode_pembayaran = $this->Master->get($this->tabel, array('id' => $id));

        // check if the metode_pembayaran exists before trying to delete it
        if (isset($metode_pembayaran['id'])) {
            if ($this->Master->delete($this->tabel, array('id' => $id))) {
                $this->msg('data', '200', '');
            };
        } else
            $this->msg('data', '404', '');
    }
}
