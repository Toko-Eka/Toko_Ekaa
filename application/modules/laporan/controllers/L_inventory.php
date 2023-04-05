<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class L_inventory extends CI_Controller {
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
		    
		 
		// if($this->session->userdata('status') != "login"){

		// 	redirect(base_url("login"));
		// }
        $this->load->library('page');

		$this->load->model('NilaiInvenModel','inven');
	}
	public function index()
	{
	
	

		
		
        $data = [
            'group'     => 'Laporan',
      
            'thisPage'   => 'Nilai Inventory / Stock'
        ];

 

        $this->page->view('inventory',$data);
		
	}
	public function invenList()
    {
        $list = $this->inven->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();

            $row[] = $trJual->NAMABRG;
           
            $row[] = $trJual->KDSUP;
           
			$akhir=0;
			if ($trJual->AKHIR == null) {
                $akhir = $trJual->AKHIR;
            } else {
                $akhir = NUMBER_FORMAT($trJual->AKHIR);
            }
            $harga = 0;
            if ($trJual->HBT == null) {
                $harga = $trJual->HBT;
            } else {
                $harga = NUMBER_FORMAT($trJual->HBT);
            }
            $sub = 0;
            if ($trJual->TOTAL == null) {
                $sub = $trJual->TOTAL;
            } else {
                $sub = NUMBER_FORMAT($trJual->TOTAL);
            }
			$row[] = $akhir;
            $row[] = $harga;

            $row[] = $sub;

            // $row[] =   date('d-m-Y', strtotime($trJual->tgl));

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
            "recordsFiltered" => $this->inven->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

	public function printInventory()
    {
      
        
     

        $result = $this->inven->repInventory();
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        // $awal = date('d-m-Y', strtotime($awal));
        // $akhir = date('d-m-Y', strtotime($akhir));
        // $label = 'Periode Tanggal ' . $awal . ' s/d ' . $akhir;

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        // $data['label'] = $label;
        $this->load->view('inventoryPrint',$data);
    }

	public function printInventoryWSupp($kdsupp)
    {
      
        
     

        $result = $this->inven->repInventorySupp($kdsupp);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        // $awal = date('d-m-Y', strtotime($awal));
        // $akhir = date('d-m-Y', strtotime($akhir));
        // $label = 'Periode Tanggal ' . $awal . ' s/d ' . $akhir;

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        // $data['label'] = $label;
        $this->load->view('inventoryPrint',$data);
    }
	public function printInventoryWBrg($brg)
    {
      
        
     
        $bar = base64_decode($brg);

  

        $result = $this->inven->repInventoryBrg($bar);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        // $awal = date('d-m-Y', strtotime($awal));
        // $akhir = date('d-m-Y', strtotime($akhir));
        $label = 'Barang '  . $bar;

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('inventoryPrint',$data);
    }
	public function printInventoryAll($kdsupp,$brg)
    {
      
        
		$bar = base64_decode($brg);

  

        $result = $this->inven->repInventoryAll($kdsupp,$bar);

   
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        // $awal = date('d-m-Y', strtotime($awal));
        // $akhir = date('d-m-Y', strtotime($akhir));
        // $label = 'Periode Tanggal ' . $awal . ' s/d ' . $akhir;

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        // $data['label'] = $label;
        $this->load->view('inventoryPrint',$data);
    }
	public function excelInventory()
    {
      
        
     

        $result = $this->inven->repInventory();
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Inventory.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('inventoryExcel',$data);
    }
	public function excelInventoryWSupp($kdsupp)
    {
      
        
     

        $result = $this->inven->repInventorySupp($kdsupp);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Inventory.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('inventoryExcel',$data);
    }
	public function excelInventoryWBrg($brg)
    {
      
		$bar = base64_decode($brg);
     

        $result = $this->inven->repInventoryBrg($bar);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Inventory.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('inventoryExcel',$data);
    }
	public function excelInventoryWAll($kdsupp,$brg)
    {
      
        
		$bar = base64_decode($brg);
     

        $result = $this->inven->repInventoryAll($kdsupp,$bar);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Inventory.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('inventoryExcel',$data);
    }
	function getGrandTotal()
    {
       
        $get = $this->inven->fetchSumWOBoth();
        echo json_encode($get);
    }
	function getGrandTotalAll()
    {
        $brg = $this->input->post('namabrg');
		$supp = $this->input->post('suppl');
        $get = $this->inven->fetchSum($brg,$supp);
        echo json_encode($get);
    }
	function getGrandTotalWBrg()
    {
     
        $brg = $this->input->post('namabrg');
        $get = $this->inven->fetchSumWoSupp($brg);
        echo json_encode($get);
    }
	function getGrandTotalWSupp()
    {
     
		$supp = $this->input->post('suppl');
        $get = $this->inven->fetchSumWoBrg($supp);
        echo json_encode($get);
    }
}