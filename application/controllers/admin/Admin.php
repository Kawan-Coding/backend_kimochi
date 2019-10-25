<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
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
    public function produk()
    {
        $data = array(
            'content' => 'content/Konten2',
        );
        $this->load->view('template_admin', $data);
    }
    public function pegawai()
    {
        $data = array(
            'content' => 'content/Konten3',
        );
        $this->load->view('template_admin', $data);
    }
    public function cabang()
    {
        $data = array(
            'content' => 'content/Konten4',
        );
        $this->load->view('template_admin', $data);
    }
    public function responsible()
    {
        $data = array(
            'content' => 'content/Konten5',
        );
        $this->load->view('template_admin', $data);
    }
    public function jenis()
    {
        $data = array(
            'content' => 'content/Konten6',
        );
        $this->load->view('template_admin', $data);
    }
    public function kategori()
    {
        $data = array(
            'content' => 'content/Konten7',
        );
        $this->load->view('template_admin', $data);
    }
    public function status_tranksaksi()
    {
        $data = array(
            'content' => 'content/Konten8',
        );
        $this->load->view('template_admin', $data);
    }
    public function barang()
    {
        $data = array(
            'content' => 'content/Konten9',
        );
        $this->load->view('template_admin', $data);
    }
    public function allowed_payment()
    {
        $data = array(
            'content' => 'content/Konten10',
        );
        $this->load->view('template_admin', $data);
    }
}
