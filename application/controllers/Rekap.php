
<?php defined('BASEPATH') or exit('No direct script access allowed');
class Rekap extends CI_Controller
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
        $data = array('content' => 'content/Rekap');
        $this->load->view('Template', $data);
    }
    public function all()
    {
        $data = data($this->M_Presensi->presensiAll());
        echo json_encode(array(
            'status' => true,
            'message' => 'Data Diterima',
            'data' => $data
        ));
    }
    public function allIndi()
    {
        $data = data3($this->M_Presensi->allIndi());
        echo json_encode(array(
            'status' => true,
            'message' => 'Data Diterima',
            'data' => $data
        ));
    }
    public function allIndiDetail($bulan, $user)
    {
        $bulan = "'" . $bulan . "'";
        $data = data2($this->M_Presensi->selectPresensi('presensi', "`USERNAME`='$user' AND MONTH(`TANGGAL`)=MONTH($bulan)"));
        echo json_encode(array(
            'status' => true,
            'message' => 'Data Diterima',
            'data' => $data
        ));
    }
    public function view($tgl)
    {
        $data = data2($this->M_Presensi->selectPresensi('presensi', array('TANGGAL' => $tgl)));
        echo json_encode(array(
            'status' => true,
            'message' => 'Data Diterima',
            'data' => $data
        ));
    }
    public function save()
    {
        $data = array(
            "KETERANGAN" => $this->input->post('status'),
            "USERNAME" => $this->input->post('username'),
            "TANGGAL" => $this->input->post('tanggal'),
            // "DETAIL" => $this->input->post('keterangan'),
        );
        $update = $this->M_Presensi->savepresensi("presensi", $data);
        if ($update) {
            $data = array(
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'data' => $data
            );
        } else {
            $data = array(
                'status' => false,
                'message' => 'Data gagal diupdate',
                'data' => $data
            );
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
