<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tamu extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_tamu');
		$this->load->helper('Parsing');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$get['content'] = 'content/tamu';
		$this->load->view('Template', $get);
	}

	public function add()
	{
		$data = $_POST['foto'];
		$file = "upload/tamu/" . strtotime(date('Y-m-d H:i:s')) . ".jpg";
		$uri = substr($data, strpos($data, ",") + 1);
		file_put_contents($file, base64_decode($uri));

		$data = array(
			'NAMA' => $this->input->post('nama'),
			'INSTANSI' => $this->input->post('instansi'),
			'JABATAN' => $this->input->post('jabatan'),
			'ALAMAT' => $this->input->post('alamat'),
		    'FOTO' => base_url().$file,
			'TELEPON' => $this->input->post('telepon')
		);
		$do = $this->M_tamu->add($data);
		if ($do) {
			echo json_encode(array(
				'error' => false,
				'message' => 'Data berhasil ditambah',
				'data' => $data
			));
		} else {
			echo json_encode(array(
				'error' => true,
				'message' => 'Data gagal ditambah',
				'data' => $data
			));
		}
	}

	public function autoload()
	{
		$data = dataTamu($this->M_tamu->getAll());
		header('Content-Type: application/json');
		echo json_encode(
			array(
				'status' => true,
				'message' => 'Data Diterima',
				'data' => $data
			)
		);
	}

	public function delete()
	{
		header('Content-Type: application/json');
		$id = $this->input->post('id');
		$do = $this->M_tamu->delete($id);
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

	public function view()
	{
		$id = $this->input->post('id');
		header('Content-Type: application/json');
		// $username='ghany';
		$get = $this->M_tamu->get(array('ID' => $id));
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
}
