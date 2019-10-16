<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata('logged')) {
			redirect('admin');
		}
		$this->load->model('M_Login');
	}

	public function index()
	{
		$this->load->view('Login');
	}

	public function login()
	{
		$where = array(
			'USERNAME' => $this->input->post('username'),
			'PASSWORD' => $this->input->post('password')
		);
		$get = $this->M_Login->auth($where);
		if (!empty($get)) {
			$get[0]['logged'] = true;
			$this->session->set_userdata($get[0]);
			echo json_encode(
				array(
					'status' => true,
					'message' => 'Username dan password cocok'
				)
			);
		} else {
			echo json_encode(
				array(
					'status' => false,
					'message' => 'Username dan password tidak cocok'
				)
			);
		}
	}
}
