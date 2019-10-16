<?php defined('BASEPATH') or exit('No direct script access allowed');
class Produk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata('logged')) {
            redirect('login');
        }
        $this->load->model('M_Produk');
        $this->load->helper('text');
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $data = array('content' => 'content/Produk');
        $this->load->view('Template', $data);
    }
    public function all()
    {
        $data = $this->data($this->M_Produk->selectAll('produk'));
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
        $id = $this->input->post('ID');
        $get = $this->M_Produk->view('Produk', array('ID' => $id))[0];
        if ($get !== false) {
            $data = array(
                'status' => 200,
                'error' => false,
                'message' => 'success',
                'data' => $get
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
        $id = $this->input->post('ID');
        if ($this->M_Produk->del('Produk', $id)) {
            echo json_encode(array(
                'status' => true,
                'message' => 'Data Berhasil Dihapus',
            ));
        } else {
            echo json_encode(array(
                'status' => false,
                'message' => 'Data Tidak Berhasil Dihapus',
            ));
        }
    }
    public function add()
    {
        $nama = $this->input->post('nama');
        $foto = str_replace(array(" ", ",", "/"), "_", $_FILES['foto']['name']);
        $deskripsi = $this->input->post('deskripsi');
        $spesifikasi = $this->input->post('spesifikasi');
        $dir = "upload/produk";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['upload_path']   = $dir;
        $config['file_name'] = $foto;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('foto')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
        }
        $data = array(
            'ID' => '',
            'NAMA' => $nama,
            'DESKRIPSI' => $deskripsi,
            'SPESIFIKASI' => $spesifikasi,
            'GAMBAR' => base_url() . 'upload/produk/' . $foto,
            'TIMESTAMP' => date('Y-m-d H:i:s')
        );
        $do = $this->M_Produk->add('produk', $data);
        redirect(base_url('produk'));
    }
    public function save()
    {
        $id = $this->input->post('id');
        $foto = str_replace(array(" ", ",", "/"), '_', $_FILES['foto-edit']['name']);
        $nama = $this->input->post('nama');
        $deskripsi = $this->input->post('deskripsi');
        $spesifikasi = $this->input->post('spesifikasi');
        if ($foto != "") {
            $dir = "upload/produk";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['upload_path']   = $dir;
            $config['file_name'] = $foto;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto-edit')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            $data = array(
                'ID' => $id,
                'NAMA' => $nama,
                'DESKRIPSI' => $deskripsi,
                'SPESIFIKASI' => $spesifikasi,
                'GAMBAR' => base_url() . 'upload/produk/' . $foto,
                'TIMESTAMP' => date('Y-m-d H:i:s')
            );
        } else {
            $data = array(
                'ID' => $id,
                'NAMA' => $nama,
                'DESKRIPSI' => $deskripsi,
                'SPESIFIKASI' => $spesifikasi,
                'TIMESTAMP' => date('Y-m-d H:i:s')
            );
        }
        $do = $this->M_Produk->save('produk', $data);
        if ($do)
            redirect(base_url('produk'));
        else
            var_dump($do);
    }
    private function data($data)
    {
        $res = array();
        $i = 1;
        foreach ($data as $key) {
            $temp = array(
                'ID' => $i,
                'NAMA' => $key['NAMA'],
                'DESKRIPSI' => word_limiter($key['DESKRIPSI'], 5),
                'SPESIFIKASI' => word_limiter($key['SPESIFIKASI'], 5),
                'GAMBAR' => $key['GAMBAR'],
                'ACTION' => '<button class="btn btn-info btn-sm" onclick="view(' . $key['ID'] . ')"><i class="fa fa-eye fa-xs"></i></button> 				<button class="btn btn-warning btn-sm text-white" onclick="edit(' . $key['ID'] . ')"><i class="far fa-edit fa-xs"></i></button> 				<button class="btn btn-danger btn-sm" onclick="del(' . $key['ID'] . ')"><i class="fa fa-times fa-xs"></i></button>'
            );
            array_push($res, $temp);
            $i++;
        }
        return $res;
    }
}
