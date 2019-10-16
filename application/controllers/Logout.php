<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		session_destroy();
		redirect('login');
	}
}
