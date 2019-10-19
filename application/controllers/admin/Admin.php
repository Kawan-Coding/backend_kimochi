<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function metode_pembayaran()
	{
		$data = array(
			'content' => 'content/konten1',
		);
		$this->load->view('template_admin', $data);
	}
	public function produk ()
	{
		$data = array(
			'content' => 'content/konten2',
		);
		$this->load->view('template_admin', $data);
	}
}
