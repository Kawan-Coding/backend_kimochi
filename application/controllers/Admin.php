<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$data=array('content'=>'content/konten1');
		$this->load->view('template_admin',$data);
		// $data=array('content'=>'content/Home');
		// $this->load->view('template_admin');
	}
}
