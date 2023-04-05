<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KartuStok extends CI_Controller {
	function  __construct(){
		parent::__construct();
		if ( ! $this->session->userdata('UserID'))
        { 
            redirect('auth');
        }
      
		$this->load->library('page');
		// $this->load->model('BarangModel','barang');
        

        $this->load->model('KartuStokModel','kartuStok');
	
	}
public function index(){
        $this->load->helper('url');
        $this->load->helper('form');
      
     
       
        $data = [
            'group'     => 'Laporan',
      
            'thisPage'   => 'Kartu Stok'
        ];
    
        $this->page->view('kartuStok',$data);
     } 
     public function printKartuStok($id,$awal,$akhir){
        $master = $this->kartuStok->getKartuStokMast($id);
        $stok = $this->kartuStok->getStokAwal($id,$awal,$akhir);
    $detail =  $this->kartuStok->getKartuStok($id,$awal,$akhir);
    $tgl_awal = date('d-m-Y', strtotime($awal));
    $tgl_akhir = date('d-m-Y', strtotime($akhir));
    $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        $data['master'] = $master;
        $data['stoka'] = $stok;
        $data['detail'] = $detail;
        $data['label'] = $label;
    
        $this->load->view('kartuStokPrint',$data);
    }
    public function excelKartuStok($id,$awal,$akhir){
        $master = $this->kartuStok->getKartuStokMast($id,$awal,$akhir);
        $stok = $this->kartuStok->getStokAwal($id,$awal,$akhir);
    $detail =  $this->kartuStok->getKartuStok($id,$awal,$akhir);
    $tgl_awal = date('d-m-Y', strtotime($awal));
    $tgl_akhir = date('d-m-Y', strtotime($akhir));
    $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        $data['master'] = $master;
        $data['stoka'] = $stok;
        $data['detail'] = $detail;
        $data['label'] = $label;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Kartu Stok Barcode $id $label.xls");
    
        $this->load->view('kartuStokPrint',$data);
    }
    function getStokAwal()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('barang');
      
        $get = $this->kartuStok->getStokAwaal($tgl_awal, $tgl_akhir,$brg);
        echo json_encode($get);
    }
    function getStokAkhir()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('barang');
      
        $get = $this->kartuStok->getStokAkhiir($tgl_awal, $tgl_akhir,$brg);
        echo json_encode($get);
    }
    function getKelMasuk()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('barang');
      
        $get = $this->kartuStok->getKelMasuk($tgl_awal, $tgl_akhir,$brg);
        echo json_encode($get);
    }
    public function kartuStokList()
    {
        $list = $this->kartuStok->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brg) {
           
            $no++;
            $row = array();
            $format = '';
            $row[] = $no;
            $format = date('d/m/Y', strtotime($brg->TGL));
            $row[] = $format;
            $ket = '';
            $jml = '';
            if ($brg->KODETRN == 'B') {
                $row[] = '';
                $row[] = $brg->JMLBRG;
              $ket = 'Beli <b> ( Nota #'.$brg->NOTA.') </b>';
            } else if ($brg->KODETRN == 'J'){
              $ket = 'Jual <b> ( Nota #'.$brg->NOTA.')</b>';
              $row[] = $brg->JMLBRG;
                       $row[] = '';
            }else if ($brg->KODETRN == 'K'){
                $ket = 'Retur Keluar <b> ( Nota #'.$brg->NOTA.')</b>';
                $row[] = $brg->JMLBRG;
                         $row[] = '';
              }else if ($brg->KODETRN == 'M'){
                $row[] = '';
                $row[] = $brg->JMLBRG;
              $ket = 'Retur Masuk <b> ( Nota #'.$brg->NOTA.') </b>';
              }
       
            $row[] = $ket;
          
            
            
          
            $role = $this->db->get_where('dbo.UserID',['UserID'=>
            $this->session->userdata('UserID')])->row_array(); 
           //  if  ($role['AccessGrp'] == 'KASIR') { 
            //add html for action
        
//   }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->kartuStok->count_all(),
                        "recordsFiltered" => $this->kartuStok->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
}