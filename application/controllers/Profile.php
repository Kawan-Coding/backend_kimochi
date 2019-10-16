<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Profile');
		$this->load->helper('text');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$username = $this->session->userdata('USERNAME');
		$get = $this->M_Profile->get(array('USERNAME' => $username))[0];
		$get['content']='content/profile';
		$this->load->view('Template', $get);
	}
}
