<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller {
	function  __construct(){
		parent::__construct();
		if ( ! $this->session->userdata('UserID'))
        { 
            redirect('auth');
        }
      
		$this->load->library('page');
		$this->load->model('Barang/BarangModel','barang');
        $this->load->model('RekapKasirModel','kasir');
        $this->load->model('RekapKasirModelDup','kasirDup');
	
	}
    public function index(){
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan',
      
            'thisPage'   => 'Rekap Kasir',
            'strat' =>  1
        ];
       
         
        $this->page->view('rekapKasir',$data);
    
      
     } 
     public function today(){
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan',
      
            'thisPage'   => 'Rekap Kasir (Hari ini)',
            'strat' =>  2
        ];
       
         
        $this->page->view('rekapKasir',$data);
    
      
     } 
     public function search(){
        // POST data
        $postData = $this->input->post();
    
        // Get data
        $data = $this->kasir->search($postData);
    
        echo json_encode($data);
      }
      public function searchNota(){
        // POST data
        $postData = $this->input->post();
    
        // Get data
        $data = $this->kasir->searchNota($postData);
    
        echo json_encode($data);
      }
     public function rekapKasirList($master,$detil)
    {
        $list = $this->kasir->get_datatables($master,$detil);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();
            $row[] = '<i id="icnsubgrid' . ($no - 1) . '" class="fas fa-plus" aria-hidden="true"></i>';
$row[] = $no;
$row[] = $trJual->TGL;
            $row[] = $trJual->NOTA;
            
          
            $sub = 0;
            if ($trJual->TOTAL == null) {
               $sub = $trJual->TOTAL;
            } else {
                $sub = NUMBER_FORMAT($trJual->TOTAL);
            }
            
          

            $row[] = $sub;
          

            $role = $this->db->get_where('dbo.UserID', ['UserID' =>
            $this->session->userdata('UserID')])->row_array();
            //              if  ($role['AccessGrp'] == 'KASIR') { 
            //              //add html for action

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            // "recordsTotal" => $this->transJual->count_allDet(),
            "recordsFiltered" => $this->kasir->count_filtered($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function rekapTotalList($master,$detil)
    {
        $list = $this->kasir->get_datatablesRekap($master,$detil);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();
        
$row[] = $no;
$row[] = $trJual->KASIR;
            $row[] = $trJual->SUPLIER;
            
          
            $sub = 0;
            if ($trJual->TOTAL == null) {
               $sub = $trJual->TOTAL;
            } else {
                $sub = NUMBER_FORMAT($trJual->TOTAL);
            }
            
          

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
            "recordsFiltered" => $this->kasir->count_filteredT($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function getRekapDetail()
    {
        $result = $this->kasir->getRekapDetail($_POST['id']);
        echo json_encode($result);
    }

     public function printRekapTotal($awal, $akhir, $supp,$master,$detil)
    {
      
        
     

        $result = $this->kasir->rekapTotal($awal, $akhir, $supp,$master,$detil);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

      
        $label = 'Rekap Semua Kasir';

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('RekapTotalPrint',$data);
    }
    public function printRekapTotalNoSupp($awal, $akhir,$master,$detil)
    {
      
        $supp='';
     

        $result = $this->kasir->rekapTotal($awal, $akhir, $supp,$master,$detil);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

      
        $label = 'Rekap Semua Kasir';

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('RekapTotalPrint',$data);
    }
    public function ExcelRekapTotal($awal, $akhir,$supp,$master,$detil)
    {
      
        
     

        $result = $this->kasir->rekapTotal($awal,$akhir,$supp,$master,$detil);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($awal));
        $tgl_akhir = date('d-m-Y', strtotime($akhir));
        $label = 'Rekap Semua Kasir Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
      
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Rekap Total $label.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('RekapTotalExcel',$data);
    }
    public function ExcelRekapTotalNoSupp($awal, $akhir,$master,$detil)
    {
      
        
     
        $supp='';
        $result = $this->kasir->rekapTotal($awal,$akhir,$supp,$master,$detil);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($awal));
        $tgl_akhir = date('d-m-Y', strtotime($akhir));
        $label = 'Rekap Semua Kasir Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
      
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Rekap Total $label.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('RekapTotalExcel',$data);
    }
	public function PrintRekapKasir($awal,$akhir,$user,$master,$detil)
    {
      
        
       
        $usr = base64_decode($user);

        $result = $this->kasir->rekapKasir($awal,$akhir,$usr,$master,$detil);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        $awal = date('d-m-Y', strtotime($awal));
        $akhir = date('d-m-Y', strtotime($akhir));
        $label = 'Rekap Kasir '.$usr.' Periode Tanggal ' . $awal . ' s/d ' . $akhir ;

        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('rekapKasirPrint',$data);
    }
    public function ExcelRekapKasir($awal,$akhir,$user,$master,$detil)
    {
      
        $usr = base64_decode($user);

        $result = $this->kasir->rekapKasir($awal,$akhir,$usr,$master,$detil);
        // $detail = $this->transBeli->getDataDet($tgl_awal, $tgl_akhir);

        $awal = date('d-m-Y', strtotime($awal));
        $akhir = date('d-m-Y', strtotime($akhir));
        $label = ''.$usr.' Periode Tanggal ' . $awal . ' s/d ' . $akhir ;
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Laporan Rekap Kasir $label.xls");
        $data['res'] = $result;
        
        // $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('rekapKasirExcel',$data);
    }
   
    function getGrandTotal()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $usr = $this->input->post('user');
        $nota = $this->input->post('nota');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->kasir->fetchSumSearch($tgl_awal, $tgl_akhir,$usr,$nota,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalWBoth()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $usr = $this->input->post('user');
        $nota = $this->input->post('nota');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
      
        $get = $this->kasir->fetchSumSearch($tgl_awal, $tgl_akhir,$usr,$nota,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalRekap()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
      
        $supp = $this->input->post('kdsup');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->kasir->sumRekapTotal($tgl_awal, $tgl_akhir,$supp,$master,$detil);
        echo json_encode($get);
    }
}