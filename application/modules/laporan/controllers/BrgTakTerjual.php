<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrgTakTerjual extends CI_Controller {
	function  __construct(){
		parent::__construct();
		if ( ! $this->session->userdata('UserID'))
        { 
            redirect('auth');
        }
      
		$this->load->library('page');
		$this->load->model('Barang/BarangModel','barang');

 
        $this->load->model('BrgNotTerjualModel','brgNotTerjual');

	
	}
    public function index()
    {
        $data = [
            'group'     => 'Laporan',
            'stat' =>  1,
            'thisPage'   => 'Barang Belum Terjual'
        ];

 
        $this->page->view('BrgNotTerjual',$data);
        
    }
    public function today()
    {
        $data = [
            'group'     => 'Laporan',
            'stat' =>  2, 
            'thisPage'   => 'Barang Belum Terjual'
        ];

 
        $this->page->view('BrgNotTerjual',$data);
        
    }
    public function brgNotTerjualList($master,$detail)
    {
        $list = $this->brgNotTerjual->get_datatables($master,$detail);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brg) {
           
            $no++;
            $row = array();
  
            $row[] = $brg->NAMABRG;

            
            $row[] = NUMBER_FORMAT($brg->HET);
        
            $row[] = NUMBER_FORMAT($brg->HBT);
            $row[] = NUMBER_FORMAT($brg->AKHIR);
      
          
            $role = $this->db->get_where('dbo.UserID',['UserID'=>
            $this->session->userdata('UserID')])->row_array(); 
           //  if  ($role['AccessGrp'] == 'KASIR') { 
            //add html for action
          
//   }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                         "recordsTotal" => $this->brgNotTerjual->count_all($master,$detail),
                        "recordsFiltered" => $this->brgNotTerjual->count_filtered($master,$detail),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    public function printNotTerjual($awal,$akhir,$barr,$master,$detail,$stok1,$stok2)
   {
     
       
       $barr = base64_decode($barr);

       $result = $this->brgNotTerjual->getNotTerjual($awal,$akhir,$barr,$master,$detail,$stok1,$stok2);
       // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

       // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
       // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
       // $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
       $label = ' Laporan barang yang tidak terjual <br> dari semua supplier ' ;
       $data['res'] = $result;
       
       // $data['det'] = $detail;
       $data['label'] = $label;

    
       $this->load->view('BrgNotTerjualPrint',$data);
   }
    public function printNotTerjualAll($awal,$akhir,$master,$detail,$stok1,$stok2)
   {
     
       $barr='';
    

       $result = $this->brgNotTerjual->getNotTerjual($awal,$akhir,$barr,$master,$detail,$stok1,$stok2);
       // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

       // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
       // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
       // $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
       $label = ' Laporan barang yang tidak terjual <br> dari semua supplier ' ;
       $data['res'] = $result;
       
       // $data['det'] = $detail;
       $data['label'] = $label;

    
       $this->load->view('BrgNotTerjualPrint',$data);
   }
   public function printNotTerjualWithSupp($awal,$akhir,$supp,$master,$detail,$stok1,$stok2)
   {
     $barr='';
       
    

       $result = $this->brgNotTerjual->getNotTerjualWithSupp($awal,$akhir,$barr,$supp,$master,$detail,$stok1,$stok2);
       // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

       // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
       // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
       $label = ' Laporan barang yang tidak terjual <br> dari supplier ' . $supp ;

       $data['res'] = $result;
       
       // $data['det'] = $detail;


       $data['label'] = $label;
       $this->load->view('BrgNotTerjualPrint',$data);
   }
   public function printNotTerjualBoth($awal,$akhir,$barr,$supp,$master,$detail,$stok1,$stok2)
   {

       
    
       $barr = base64_decode($barr);
       $result = $this->brgNotTerjual->getNotTerjualWithSupp($awal,$akhir,$barr,$supp,$master,$detail,$stok1,$stok2);
       // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

       // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
       // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
       $label = ' Laporan barang yang tidak terjual <br> dari supplier ' . $supp ;

       $data['res'] = $result;
       
       // $data['det'] = $detail;


       $data['label'] = $label;
       $this->load->view('BrgNotTerjualPrint',$data);
   }
   public function excelNotTerjual($awal,$akhir,$barr,$master,$detail,$stok1,$stok2)
   {
     
       
       $barr = base64_decode($barr);

       $result = $this->brgNotTerjual->getNotTerjual($awal,$akhir,$barr,$master,$detail,$stok1,$stok2);
       // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

       // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
       // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
       // $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
       $label = ' Laporan barang yang tidak terjual <br> dari semua supplier ' ;
       header("Content-type: application/vnd-ms-excel");
       header("Content-Disposition: attachment; filename=Laporan barang yang tidak terjual dari semua supplier.xls");
       $data['res'] = $result;
       
       // $data['det'] = $detail;
       $data['label'] = $label;

    
       $this->load->view('BrgNotTerjualExcel',$data);
   }
   public function excelNotTerjualAll($awal,$akhir,$master,$detail,$stok1,$stok2)
   {
     
       
    $barr='';

       $result = $this->brgNotTerjual->getNotTerjual($awal,$akhir, $barr,$master,$detail,$stok1,$stok2);
       // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

       // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
       // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
       // $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
       $label = ' Laporan barang yang tidak terjual <br> dari semua supplier ' ;
       header("Content-type: application/vnd-ms-excel");
       header("Content-Disposition: attachment; filename=Laporan barang yang tidak terjual dari semua supplier.xls");
       $data['res'] = $result;
       
       // $data['det'] = $detail;
       $data['label'] = $label;

    
       $this->load->view('BrgNotTerjualExcel',$data);
   }
   public function excelNotTerjualWithSupp($awal,$akhir,$supp,$master,$detail,$stok1,$stok2)
   {
     
       
    $barr='';

       $result = $this->brgNotTerjual->getNotTerjualWithSupp($awal,$akhir,$barr,$supp,$master,$detail,$stok1,$stok2);
       // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

       // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
       // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
       $label = ' Laporan barang yang tidak terjual <br> dari supplier ' . $supp ;
       header("Content-type: application/vnd-ms-excel");
       header("Content-Disposition: attachment; filename=Laporan barang yang tidak terjual <br> dari supplier ' . $namasupp.xls");
       $data['res'] = $result;
       
       // $data['det'] = $detail;


       $data['label'] = $label;
       $this->load->view('BrgNotTerjualExcel',$data);
   }
   public function excelNotTerjualBoth($awal,$akhir,$barr,$supp,$master,$detail,$stok1,$stok2)
   {
     
       
       $barr = base64_decode($barr);

       $result = $this->brgNotTerjual->getNotTerjualWithSupp($awal,$akhir,$barr,$supp,$master,$detail,$stok1,$stok2);
       // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

       // $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
       // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
       $label = ' Laporan barang yang tidak terjual <br> dari supplier ' . $supp ;
       header("Content-type: application/vnd-ms-excel");
       header("Content-Disposition: attachment; filename=Laporan barang yang tidak terjual <br> dari supplier ' . $supp.xls");
       $data['res'] = $result;
       
       // $data['det'] = $detail;


       $data['label'] = $label;
       $this->load->view('BrgNotTerjualExcel',$data);
   }
}