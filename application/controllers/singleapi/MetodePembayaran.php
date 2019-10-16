<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MetodePembayaran extends CI_Controller
{
    protected $date;
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        // $this->load->model('user');
        $this->date = new DateTime();
        //==== ALLOWING CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    }
    public function response($data)
    {

        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    public function index()
    {
        $data['metode_pembayaran'] = $this->Master->get_all_metode_pembayaran();
        return $this->response([
            'error' => false,
            'message' => 'sukses',
            'data' => $data['metode_pembayaran']
        ]);
    }

    /*
     * Adding a new metode_pembayaran
     */
    function add()
    {
        if (isset($_POST) && count($_POST) > 0) {
            $params = array(
                'nama' => $this->input->post('nama'),
                'nomor' => $this->input->post('nomor'),
                'create_at' => $this->date->getTimestamp(),
            );
            if ($this->Master->add_metode_pembayaran($params)) {
                return $this->response([
                    'error' => false,
                    'message' => 'sukses',
                    'data' => ''
                ]);
            };
        } else {
            return $this->response([
                'error' => true,
                'message' => 'belum ada masukan',
                'data' => ''
            ]);
        }
    }

    /*
     * Editing a metode_pembayaran
     */
    function edit()
    {
        // check if the metode_pembayaran exists before trying to edit it
        $id =  $this->input->post('id');
        $data['metode_pembayaran'] = $this->Master->get_metode_pembayaran($id);
        if (isset($data['metode_pembayaran']['id'])) {
            if (isset($_POST) && count($_POST) > 0) {
                $params = array(
                    'nama' => $this->input->post('nama'),
                    'nomor' => $this->input->post('nomor'),
                );
                if ($this->Master->update_metode_pembayaran($id, $params)) {
                    return $this->response([
                        'error' => false,
                        'message' => 'sukses',
                        'data' => ''
                    ]);
                };
            } else {
                return $this->response([
                    'error' => true,
                    'message' => 'belum ada masukan',
                    'data' => ''
                ]);
            }
        } else
            return $this->response([
                'error' => true,
                'message' => 'The metode_pembayaran you are trying to edit does not exist.',
                'data' => ''
            ]);
    }

    /*
     * Deleting metode_pembayaran
     */
    function remove()
    {
        $id =  $this->input->post('id');
        $metode_pembayaran = $this->Master->get_metode_pembayaran($id);

        // check if the metode_pembayaran exists before trying to delete it
        if (isset($metode_pembayaran['id'])) {
            if ($this->Master->delete_metode_pembayaran($id)) {
                return $this->response([
                    'error' => false,
                    'message' => 'sukses',
                    'data' => ''
                ]);
            };
        } else
        return $this->response([
            'error' => true,
            'message' => 'The metode_pembayaran you are trying to remove does not exist.',
            'data' => ''
        ]);
    }
}
