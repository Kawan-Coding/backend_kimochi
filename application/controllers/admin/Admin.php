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
			'content' => 'content/Konten1',
		);
		$this->load->view('template_admin', $data);
	}
	public function produk ()
	{
		$data = array(
			'content' => 'content/Konten2',
		);
		$this->load->view('template_admin', $data);
	}
	public function pegawai ()
	{
		$data = array(
			'content' => 'content/Konten3',
		);
		$this->load->view('template_admin', $data);
	}
	public function cabang ()
	{
		$data = array(
			'content' => 'content/Konten4',
		);
		$this->load->view('template_admin', $data);
	}
}
