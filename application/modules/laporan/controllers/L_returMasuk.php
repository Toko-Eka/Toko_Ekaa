<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class L_returMasuk extends CI_Controller {
	function  __construct(){
		parent::__construct();
	
		if ( ! $this->session->userdata('UserID'))
        { 
            redirect('auth');
        }
		// $this->load->model('Meja_Model');
		// $this->load->model('Menu_Model');
		// $this->load->model('auth_model');
		// $this->load->model('invoice_Model');
		$this->load->model('ReturModel', 'retur');
		$this->load->library('page');
		 
		// if($this->session->userdata('status') != "login"){

		// 	redirect(base_url("login"));
		// }

	}
	public function index()
	{
        $data = [
            'group'     => 'Laporan',
      
            'thisPage'   => 'Retur Masuk'
        ];

 
        $this->page->view('returMasuk',$data);
		
	}
	public function RT()
    {
        $list = $this->retur->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();

            $row[] = $trJual->NOTA;
            $row[] = $trJual->KDBRG;
            $row[] = $trJual->NAMABRG;
            $row[] = $trJual->KDSUP;
            $row[] = $trJual->JMLBRG;
            $harga = 0;
            if ($trJual->HARGA == null) {
               $harga = $trJual->HARGA;
            } else {
                $harga = NUMBER_FORMAT($trJual->HARGA);
            }
            $sub = 0;
            if ($trJual->TOTAL == null) {
               $sub = $trJual->TOTAL;
            } else {
                $sub = NUMBER_FORMAT($trJual->TOTAL);
            }
            
            $row[] = $harga;

            $row[] = $sub;
            
            $row[] =   date('d-m-Y', strtotime($trJual->tgl));

            // $row[] = NUMBER_FORMAT($trJual->JMLBRG);
            // $row[] = NUMBER_FORMAT($trJual->TOTAL,2);

            // $unpaid = '';
            // if ($trJual->PAID == 0) {
            //     $unpaid = '<span class ="badge badge-sm badge-danger">Belum dibayar</span>';
            // } else {
            //     $unpaid = '<span class ="badge badge-sm badge-success">Sudah dibayar</span>';
            // }

            // $row[] = $unpaid;

            // // $row[] = $trJual->KET1;
            // $row[] = $trJual->KASIR;

            $role = $this->db->get_where('dbo.UserID', ['UserID' =>
            $this->session->userdata('UserID')])->row_array();
            //              if  ($role['AccessGrp'] == 'KASIR') { 
            //              //add html for action

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            // "recordsTotal" => $this->transJual->count_allDet(),
            "recordsFiltered" => $this->ret->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function retMasukList()
    {
        $list = $this->retur->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();

            $row[] = date('d-m-Y', strtotime($trJual->TGL));
            $row[] = date('d-m-Y', strtotime($trJual->tgl));
            $row[] = $trJual->NAMABRG;
            // $row[] = $trJual->KDSUP;
            $row[] = $trJual->JMLBRG;
            $row[] = $trJual->KET1;
  
            
     

            // $row[] = NUMBER_FORMAT($trJual->JMLBRG);
            // $row[] = NUMBER_FORMAT($trJual->TOTAL,2);

            // $unpaid = '';
            // if ($trJual->PAID == 0) {
            //     $unpaid = '<span class ="badge badge-sm badge-danger">Belum dibayar</span>';
            // } else {
            //     $unpaid = '<span class ="badge badge-sm badge-success">Sudah dibayar</span>';
            // }

            // $row[] = $unpaid;

            // // $row[] = $trJual->KET1;
            // $row[] = $trJual->KASIR;

            $role = $this->db->get_where('dbo.UserID', ['UserID' =>
            $this->session->userdata('UserID')])->row_array();
            //              if  ($role['AccessGrp'] == 'KASIR') { 
            //              //add html for action

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            // "recordsTotal" => $this->transJual->count_allDet(),
            "recordsFiltered" => $this->retur->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function print($awal, $akhir)
	{
	  
		
		$tgl_awal = $awal;
		$tgl_akhir = $akhir;

		$retur = $this->retur->returMasuk($tgl_awal, $tgl_akhir);
		

		$tgl_awal = date('d-m-Y', strtotime($tgl_awal));
		$tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
		$label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

		$data['retMasuk'] = $retur;

		


		$data['label'] = $label;
		$this->load->view('returMasukPrint',$data);
	}
	public function excel($awal, $akhir)
	{
	  
		
		$tgl_awal = $awal;
		$tgl_akhir = $akhir;

		$retur = $this->retur->returMasuk($tgl_awal, $tgl_akhir);
		

		$tgl_awal = date('d-m-Y', strtotime($tgl_awal));
		$tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
		$label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Retur Masuk $label.xls");
		$data['retKel'] = $retur;

		


		$data['label'] = $label;
		$this->load->view('returMasukExcel',$data);
	}
	public function printWSupp($awal, $akhir,$supp)
	{
	  
		
		$tgl_awal = $awal;
		$tgl_akhir = $akhir;

		$retur = $this->retur->returMasukWithSupp($tgl_awal, $tgl_akhir,$supp);
		

		$tgl_awal = date('d-m-Y', strtotime($tgl_awal));
		$tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
		$label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

		$data['retMasuk'] = $retur;

		


		$data['label'] = $label;
		$this->load->view('returMasukPrint',$data);
	}
	public function excelWSupp($awal, $akhir,$supp)
	{
	  
		
		$tgl_awal = $awal;
		$tgl_akhir = $akhir;

		$retur = $this->retur->returMasukWithSupp($tgl_awal, $tgl_akhir,$supp);
		

		$tgl_awal = date('d-m-Y', strtotime($tgl_awal));
		$tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
		$label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Retur Masuk $label.xls");
		$data['retKel'] = $retur;

		


		$data['label'] = $label;
		$this->load->view('returMasukExcel',$data);
	}
	}
