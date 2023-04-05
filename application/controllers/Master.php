<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	function  __construct(){
		parent::__construct();
	
		if ( ! $this->session->userdata('UserID'))
        { 
            redirect('auth');
        }
		$this->load->library('page');
		$this->load->model('Penjualan/TransaksiJualModel', 'transJual');
		$this->load->model('Pembelian/TransaksiBeliModel', 'transBeli');
		$this->load->model('Barang/BarangModel', 'barang');
	
		    
		 
		// if($this->session->userdata('status') != "login"){

		// 	redirect(base_url("login"));
		// }

	}
	public function index()
	{
	  
        $data = [
            'group'     => 'Home',
      
            'thisPage'   => 'Dashboard'
        ];
	
		$this->page->view('temp/main_content',$data);
		
	}
	function getGrandTotalJual(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $get = $this->transJual->fetchSumDashboardJ($tgl_awal, $tgl_akhir);
        echo json_encode($get);
    }
	function getGrandTotalBeli(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $get = $this->transJual->fetchSumDashboardB($tgl_awal, $tgl_akhir);
        echo json_encode($get);
    }
	}
