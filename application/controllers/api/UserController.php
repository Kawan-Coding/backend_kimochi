<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('user');

        //==== ALLOWING CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    }

    public function response($data, $error = "false")
    {

        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
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

    public function register()
    {
        return $this->response($this->user->save());
    }
    function is_valid()
    {
        if (isset($_POST) && count($_POST) <= 0) {
            $this->msg('', '400', '','tidak ada masukan');        }
    }

    public function login()
    {
        //return dibuat disini untuk antisipasi penambahan fitur pada login
        $this->is_valid();
        if (!$this->user->is_valid()) {

            return $this->response([
                'error' => true,
                'message' => 'username atau password salah',
                'data' => ''
            ]);
        } elseif ($this->user->is_valid()) {
            $cash_flow_status = $this->user->get_status_last_cashflow();
            return $this->response([
                'error' => false,
                'message' => 'login berhasil',
                'data' => [
                    'cash_flow_status'=>$cash_flow_status?$cash_flow_status:"validated",
                    'login'=>'login',
                    'responsible'=>[
                        'pegawai'=>$this->user->get('username',$_POST['username']),
                        'cabang'=>$this->user->get_responsible()
                    ],
                ]
            ]);
        }
    }

    public function update($id)
	{
		$data = $this->get_input();
		if ($this->protected_method($id)) {
			return $this->response($this->user->update($id, $data));
		}
	}
}
