<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashRegisterController extends CI_Controller {
	public function index()
	{
        parent::_construct();
        $this->load->model('CashRegister');
        		//==== ALLOWING CORS
		header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    }
    
    public function open(){
        echo "cok";
    }
    public function close(){
        echo "cok";
    }
}
