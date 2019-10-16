<?php defined('BASEPATH') or exit('No direct script access allowed');
class Presensi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata('logged')) {
            redirect('login');
        }
        $this->load->model('M_Presensi');
        $this->load->helper('Parsing');
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $data = array('content' => 'content/Presensi');
        $this->load->view('Template', $data);
    }
    private function rad($x)
    {
        return $x * M_PI / 180;
    }
    private function jarak($lat, $long)
    {
        $R = 6371;
        $dLat = $this->rad(($lat) - (-7.9314938));
        $dLong = $this->rad($long - 112.615487);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos($this->rad(-7.9314938)) * cos($this->rad($lat)) * sin($dLong / 2) * sin($dLong / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $R * $c;
        return number_format($d, 1, '.', ',');
    }
    public function view()
    {
        $data = data2($this->M_Presensi->selectPresensi('presensi', array('USERNAME' => $_SESSION['USERNAME'])));
        echo json_encode(array('status' => true,             'message' => 'Data Diterima',             'data' => $data));
    }
    public function add()
    {
        $lat = $this->input->post('LAT');
        $long = $this->input->post('LONG');
        $jarak = $this->jarak($lat, $long);
        if ($jarak > 8.5) {
            echo json_encode(array('status' => false,                 'message' => 'jarak'));
        } else {
            $USERNAME = $_SESSION['USERNAME'];
            $nama = $_SESSION['NAMA'];
            $masuk = date("H:i:s");
            $data = array('TANGGAL' => date('Y-m-d'),                 'USERNAME' => $USERNAME,                 'NAMA' => $nama,                 'MASUK' => $masuk,);
            $do = $this->M_Presensi->add('presensi', $data);
            if ($do == 1) {
                echo json_encode(array('status' => true,                         'message' => 'Berhasil melakukan check in'));
            } else {
                echo json_encode(array('status' => false,                         'message' => 'Gagal melakukan check in'));
            }
        }
    }
    public function ijin()
    {
        $USERNAME = $_SESSION['USERNAME'];
        $nama = $_SESSION['NAMA'];
        $masuk = date("H:i:s");
        $alasan = $this->input->post('alasan');
        $ket = $this->input->post('keterangan');
        $data = array('TANGGAL' => date('Y-m-d'),             'USERNAME' => $USERNAME,             'NAMA' => $nama,             'MASUK' => $masuk,             'KETERANGAN' => $ket,             'DETAIL' => $alasan);
        $do = $this->M_Presensi->add('presensi', $data);
        if ($do == 1) {
            echo json_encode(array('status' => true,                     'message' => 'Berhasil melakukan check in'));
        } else {
            echo json_encode(array('status' => false,                     'message' => 'Gagal melakukan check in'));
        }
    }
    public function save()
    {
        $USERNAME = $_SESSION['USERNAME'];
        $keluar = date("H:i:s");
        $data = array('TANGGAL' => date('Y-m-d'),             'USERNAME' => $USERNAME,             'KELUAR' => $keluar,);
        $do = $this->M_Presensi->savepresensi('presensi', $data);
        if ($do == 1) {
            echo json_encode(array('status' => true,                     'message' => 'Berhasil melakukan check out'));
        } else {
            echo json_encode(array('status' => false,                     'message' => 'Gagal melakukan check out'));
        }
    }
}
