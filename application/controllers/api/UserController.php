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

    public function register()
    {
        return $this->response($this->user->save());
    }


    public function login()
    {
        //return dibuat disini untuk antisipasi penambahan fitur pada login

        if (!$this->user->is_valid()) {

            return $this->response([
                'error' => true,
                'message' => 'username atau password salah',
                'data' => ''
            ]);
        } elseif ($this->user->is_valid()) {
            return $this->response([
                'error' => false,
                'message' => 'login berhasil',
                'data' => [
                    'cash_flow_status'=>$this->user->get_status_last_cashflow(),
                    'login'=>'login',
                    'responsible'=>'',
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
