<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Msg 
{

    function response($data)
    {

        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        // exit;
    }
    function foo($data)
    {
        echo "foo";
    }

    function get($name, $status, $data, $custom_msg = '')
    {
        $msg_data = array(
            'error' => true,
            'msg' => '',
            'data' => $data
        );
        switch ($status) {
            case '200':
                $msg_data['msg'] = 'query berhasil';
                $msg_data['error'] = false;
                break;
                case '204':
                $msg_data['msg'] = $name . ' ' . 'not exist'.' '.$custom_msg;
                $msg_data['error'] = false;
                break;
            case '300':
                $msg_data['msg'] = 'AUTH POLICY'.' '.$custom_msg;
                // $msg_data['error'] = true;
                break;
            case '400':
                $msg_data['msg'] = 'query gagal ' . ' '.$custom_msg;
                // $msg_data['error'] = false;
                break;

            default:
                $msg_data['msg'] = $custom_msg;
                // $msg_data['error'] = false;
                break;
        }
        // $msg_data['custom_error_msg'] = $custom_msg;
        return $msg_data;
        // return $this->response([
        //     $msg_data
        // ]);
    }

    
}
