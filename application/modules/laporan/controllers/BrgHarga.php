<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrgHarga extends CI_Controller {
	function  __construct(){
		parent::__construct();
		if ( ! $this->session->userdata('UserID'))
        { 
            redirect('auth');
        }
      
		$this->load->library('page');
		$this->load->model('Barang/BarangModel','barang');
        
		$this->load->model('HargaBarangModel','brgHarga');

	
	}
    public function index(){
        $this->load->helper('url');
        $this->load->helper('form');
      
       
        $data = [
            'group'     => 'Laporan',
      
            'thisPage'   => 'Harga Barang /Supplier'
        ];
    
        $this->page->view('barangHargaSupp',$data);
     } 
     public function brgHargaList()
     {
         $list = $this->brgHarga->get_datatables();
         $data = array();
         $no = $_POST['start'];
         foreach ($list as $brg) {
            
             $no++;
             $row = array();
   
             $row[] = $brg->NAMABRG;

             $HET='';
             if ($brg->HET < 1) {
                $HET='0';
             } else {
                $HET=NUMBER_FORMAT($brg->HET);
             }
             
             $row[] = $HET;
             $row[] = round((float)$brg->RLABA * 1 ) . '%';
             $HBT='';
             if ($brg->HBT < 1) {
                $HBT='0';
             } else {
                $HBT=NUMBER_FORMAT($brg->HBT);
             }
             
             $row[] = $HBT;
             $JHAR1='';
             if ($brg->JHAR1 < 1) {
                $JHAR1='0';
             } else {
                $JHAR1=NUMBER_FORMAT($brg->JHAR1);
             }
             
             $row[] = $JHAR1;
             $JHAR2='';
             if ($brg->JHAR2 < 1) {
                $JHAR2='0';
             } else {
                $JHAR2=NUMBER_FORMAT($brg->JHAR2);
             }
             
             $row[] = $JHAR2;
             $JHAR3='';
             if ($brg->JHAR3 < 1) {
                $JHAR3='0';
             } else {
                $JHAR3=NUMBER_FORMAT($brg->JHAR3);
             }
             
             $row[] = $JHAR3;
             $JHAR4='';
             if ($brg->JHAR4 < 1) {
                $JHAR4='0';
             } else {
                $JHAR4=NUMBER_FORMAT($brg->JHAR4);
             }
             
             $row[] = $JHAR4;
             $JHAR5='';
             if ($brg->JHAR5 < 1) {
                $JHAR5='0';
             } else {
                $JHAR5=NUMBER_FORMAT($brg->JHAR5);
             }
             
             $row[] = $JHAR5;
             $HKANVAS='';
             if ($brg->HKANVAS < 1) {
                $HKANVAS='0';
             } else {
                $HKANVAS=NUMBER_FORMAT($brg->HKANVAS);
             }
             
             $row[] = $HKANVAS;
           
             $role = $this->db->get_where('dbo.UserID',['UserID'=>
             $this->session->userdata('UserID')])->row_array(); 
            //  if  ($role['AccessGrp'] == 'KASIR') { 
             //add html for action
           
//   }
             $data[] = $row;
         }
  
         $output = array(
                         "draw" => $_POST['draw'],
                        //  "recordsTotal" => $this->brgHarga->count_all(),
                         "recordsFiltered" => $this->brgHarga->count_filtered(),
                         "data" => $data,
                 );
         //output to json format
         echo json_encode($output);
     }
    
    public function printHarga($supp,$namasupp)
    {
      
        
     

        $result = $this->brgHarga->getHarga($supp);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = ' dari supplier ' . $namasupp ;

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('barangHargaSuppPrint',$data);
    }
    public function printHargaAll()
    {
      
        
     

        $result = $this->brgHarga->getHargaAll();
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = ' dari Semua Supplier ' ;

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('barangHargaSuppPrint',$data);
    }
    public function excelHarga($supp,$namasupp)
    {
      
        
     

        $result = $this->brgHarga->getHarga($supp);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = '  dari supplier ' . $namasupp ;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Harga Barang/Supplier$label.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('barangHargaSuppExcel',$data);
    }
    public function excelHargaAll()
    {
      
        
     

        $result = $this->brgHarga->getHargaAll();
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'dari Semua Supplier ' ;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Harga Barang/Supplier $label.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('barangHargaSuppExcel',$data);
    }
}