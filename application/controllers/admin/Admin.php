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
            'content' => 'Content/Konten1',
        );
        $this->load->view('template_admin', $data);
    }
    public function produk()
    {
        $data = array(
            'content' => 'Content/Konten2',
        );
        $this->load->view('template_admin', $data);
    }
    public function pegawai()
    {
        $data = array(
            'content' => 'Content/Konten3',
        );
        $this->load->view('template_admin', $data);
    }
    public function cabang()
    {
        $data = array(
            'content' => 'Content/Konten4',
        );
        $this->load->view('template_admin', $data);
    }
    public function responsible()
    {
        $data = array(
            'content' => 'Content/Konten5',
        );
        $this->load->view('template_admin', $data);
    }
    public function jenis()
    {
        $data = array(
            'content' => 'Content/Konten6',
        );
        $this->load->view('template_admin', $data);
    }
    public function kategori()
    {
        $data = array(
            'content' => 'Content/Konten7',
        );
        $this->load->view('template_admin', $data);
    }
    public function status_tranksaksi()
    {
        $data = array(
            'content' => 'Content/Konten8',
        );
        $this->load->view('template_admin', $data);
    }
    public function barang()
    {
        $data = array(
            'content' => 'Content/Konten9',
        );
        $this->load->view('template_admin', $data);
    }
    public function allowed_payment()
    {
        $data = array(
            'content' => 'Content/Konten10',
        );
        $this->load->view('template_admin', $data);
    }
}
