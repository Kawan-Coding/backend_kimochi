<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Profile');
		$this->load->helper('Parsing');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data = array('content' => 'content/anggota');
		$this->load->view('Template', $data);
	}

	public function all()
	{
		$data = dataUser($this->M_Profile->getAll());
		header('Content-Type: application/json');
		echo json_encode(
			array(
				'status' => true,
				'message' => 'Data Diterima',
				'data' => $data
			)
		);
	}

	public function view()
	{
		$username = $this->input->post('USERNAME');
		header('Content-Type: application/json');
		// $username='ghany';
		$get = $this->M_Profile->get(array('USERNAME' => $username));
		if ($get !== false) {
			$data = array(
				'status' => 200,
				'error' => false,
				'message' => 'success',
				'data' => $get[0]
			);
			echo json_encode($data);
		} else {
			echo json_encode(
				array(
					'status' => 500,
					'error' => true,
					'message' => 'failed to do'
				)
			);
		}
	}
	public function delete()
	{
		header('Content-Type: application/json');
		$id = $this->input->post('username');
		$do = $this->M_Profile->delete($id);
		if ($do) {
			echo json_encode(array(
				'error' => false,
				'message' => 'Data Berhasil Dihapus',
			));
		} else {
			echo json_encode(array(
				'error' => true,
				'message' => 'Data Tidak Berhasil Dihapus',
			));
		}
	}
	public function save()
	{
		$where = array(
			"USERNAME" => $this->input->post('username_lama'),
			"PASSWORD" => $this->input->post('password_lama'),
		);
		$data = array(
			"PASSWORD" => $this->input->post('password'),
			"NAMA" => $this->input->post('nama'),
			"ALAMAT" => $this->input->post('alamat'),
			"FOTO" => $this->input->post('foto'),
			"EMAIL" => $this->input->post('email'),
			"TELEPON" => $this->input->post('telepon'),
			"JABATAN" => $this->input->post('jabatan'),
			"ROLE" => $this->input->post('role')
		);
		$do = $this->M_Profile->update($where, $data);
		if ($do) {
			echo json_encode(array(
				'error' => false,
				'message' => 'Data Berhasil disimpan',
				'data'=>$data
			));
		} else {
			echo json_encode(array(
				'error' => true,
				'message' => 'Data Tidak Berhasil disimpan',
			));
		}
	}
	public function add()
	{
		$data = array(
			"USERNAME" => $this->input->post('username'),
			"PASSWORD" => $this->input->post('password'),
			"NAMA" => $this->input->post('nama'),
			"ALAMAT" => $this->input->post('alamat'),
			"FOTO" => $this->input->post('foto'),
			"EMAIL" => $this->input->post('email'),
			"TELEPON" => $this->input->post('telepon'),
			"JABATAN" => $this->input->post('jabatan'),
			"ROLE" => $this->input->post('role')
		);
		$do = $this->M_Profile->add($data);
		if ($do) {
			echo json_encode(array(
				'error' => false,
				'message' => 'Data Berhasil disimpan',
			));
		} else {
			echo json_encode(array(
				'error' => true,
				'message' => 'Data Tidak Berhasil disimpan',
			));
		}
	}
}
