<?php
defined('BASEPATH') or exit('No direct script access allowed');

class uploadImport extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('UserID')) {
            redirect('auth');  }
        $this->load->model('upload_model');
        $this->load->helper('file');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url'));
    }
    public function index()
    {
        error_reporting(0);
        $this->load->view('temp/v_header');
        $this->load->view('settings/import');
        $this->load->view('temp/v_footer');
    }
  
    public function do_upload()
    {
        // $this->upload_model->detachDB();  



        error_reporting(0);
        $data = [];

        $count = count($_FILES['files']['name']);

        for ($i = 0; $i < $count; $i++) {

            if (!empty($_FILES['files']['name'][$i])) {

                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                //   $config['overwrite'] = ' TRUE';

                $config['upload_path'] = 'assets/uploadDB';
                $config['allowed_types'] = '*';
                $config['max_size'] = '500000000';
                $config['file_name'] = $_FILES['files']['name'][$i];

                $this->upload->initialize($config);
                //   $this->upload->overwrite = true;
                // $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {

                    // $data = array('upload_data' => $this->upload->data());
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];

                    $data['totalFiles'][] = $filename;
                } else {

                    $error = array('error' => $this->upload->display_errors());
                    $this->load->view('temp/v_header', $error);
                    $this->load->view('settings/import', $error);
                    $this->load->view('temp/v_footer', $error);
                }
            }
        }
      

        $this->load->view('temp/v_header', $data);
        $this->load->view('settings/import', $data);
        $this->load->view('temp/v_footer', $data);
    }

    public function switchdb($primary,$log)
    {
        $param1 = $primary;
      $param2 = $log;
        $result = $this->upload_model->attachDB($param1,$param2);
    
        // var_dump($result);
        echo 'import berhasil, silahkan kembali';
        // delete_files('./assets/uploadDB/');
    }
}
