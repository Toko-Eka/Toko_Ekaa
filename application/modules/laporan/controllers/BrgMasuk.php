<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrgMasuk extends CI_Controller {
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
		$this->load->model('Barang/BarangModel', 'barang');
 
		$this->load->model('BarangMasukModel','brgMasuk');
		 
		// if($this->session->userdata('status') != "login"){

		// 	redirect(base_url("login"));
		// }

	}
	public function index()
	{
        $data = [
            'group'     => 'Laporan',
      'strat' => 1,
            'thisPage'   => 'Barang Masuk (Beli) Per Supplier / Barang'
        ];
 
		$this->page->view('barangMasukSupp',$data);
	}
	public function brgMasukList($master,$detil)
	{
		$list = $this->brgMasuk->get_datatables($master,$detil);
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
			
			$row[] = $harga;

			$row[] = $sub;
			
			$row[] =   date('d-m-Y', strtotime($trJual->TGL));

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

		
			//              if  ($role['AccessGrp'] == 'KASIR') { 
			//              //add html for action

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			// "recordsTotal" => $this->transJual->count_allDet(),
			"recordsFiltered" => $this->brgMasuk->count_filtered($master,$detil),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function printDet($awal, $akhir,$supp,$brg,$master,$detil)
	{
	  
		
		$tgl_awal = $awal;
		$tgl_akhir = $akhir;
$suppl = $supp;
$barr = base64_decode($brg);
		$transaksi = $this->brgMasuk->view_by_dateDet($tgl_awal, $tgl_akhir,$suppl,$barr,$master,$detil);
		$sum = $this->brgMasuk->fetchSum($tgl_awal, $tgl_akhir,$suppl,$barr,$master,$detil);

		$tgl_awal = date('d-m-Y', strtotime($tgl_awal));
		$tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
		$label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

		$data['transak'] = $transaksi;
		$data['grandtotal'] = $sum;

		


		$data['label'] = $label;
		$this->load->view('barangMasukSuppPrint',$data);
	}
	public function printDetNo($awal, $akhir,$master,$detil)
  {
	
	  
	  $tgl_awal = $awal;
	  $tgl_akhir = $akhir;

	  $transaksi = $this->brgMasuk->view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir,$master,$detil);
	//   $sum = $this->transBeli->fetchSumWOBoth($tgl_awal, $tgl_akhir);

	  $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
	  $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
	  $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

	  $data['transak'] = $transaksi;
	//   $data['grandtotal'] = $sum;



	  $data['label'] = $label;
	  $this->load->view('barangMasukSuppPrint',$data);
  }
  public function printDetWOBrg($awal, $akhir,$supp,$master,$detil)
  {
	
	  
	  $tgl_awal = $awal;
	  $tgl_akhir = $akhir;
$suppl = $supp;

	  $transaksi = $this->brgMasuk->view_by_dateDetWithSupp($tgl_awal, $tgl_akhir,$suppl,$master,$detil);
	//   $sum = $this->transBeli->fetchSumWOBrg($tgl_awal, $tgl_akhir,$suppl);

	  $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
	  $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
	  $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

	  $data['transak'] = $transaksi;
	//   $data['grandtotal'] = $sum;



	  $data['label'] = $label;
	  $this->load->view('barangMasukSuppPrint',$data);
  }
  public function printDetWOSupp($awal, $akhir,$brg,$master,$detil)
  {
	
	  
	  $tgl_awal = $awal;
	  $tgl_akhir = $akhir;
	  $barr = base64_decode($brg);

	  $transaksi = $this->brgMasuk->view_by_dateDetWithBrg($tgl_awal, $tgl_akhir,$barr,$master,$detil);
	//   $sum = $this->transBeli->fetchSumWOSupp($tgl_awal, $tgl_akhir,$barr);

	  $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
	  $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
	  $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

	  $data['transak'] = $transaksi;
	//   $data['grandtotal'] = $sum;



	  $data['label'] = $label;
	  $this->load->view('barangMasukSuppPrint',$data);
  }
  //   public function excelDet($awal, $akhir,$supp= NULL,$brg= NULL){
  //     $tgl_awal = $awal;
  //     $tgl_akhir = $akhir;
  //     $suppl = $supp;
  //     $barr = $brg;
  //     $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
  //     $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
  //     $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
  //       header("Content-type: application/vnd-ms-excel");
  //       header("Content-Disposition: attachment; filename=Laporan Transaksi Beli $label.xls");
  //       $tgl_awal = $awal;
  //       $tgl_akhir = $akhir;
  //       $suppl = $supp;
  //       $barr = $brg;
  //       $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
  //       $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
  //       $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
	  
	 

  //       $transaksi = $this->transBeli->view_by_dateDet($tgl_awal, $tgl_akhir,$suppl,$barr);


	  

  //       $data['transak'] = $transaksi;
		
 


  //       $data['label'] = $label;
  //       $this->load->view('transaksiBeli/historyPrintDet',$data);
  //     }
  public function excelDet($awal, $akhir,$supp,$brg,$master,$detil)
  {
	
	  
	  $tgl_awal = $awal;
	  $tgl_akhir = $akhir;
$suppl = $supp;
$barr = base64_decode($brg);
	  $transaksi = $this->brgMasuk->view_by_dateDet($tgl_awal, $tgl_akhir,$suppl,$barr,$master,$detil);
	  $sum = $this->brgMasuk->fetchSum($tgl_awal, $tgl_akhir,$suppl,$barr,$master,$detil);

	  $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
	  $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
	  $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
	  header("Content-type: application/vnd-ms-excel");
	  header("Content-Disposition: attachment; filename=Laporan Transaksi Beli $label.xls");
	  $data['transak'] = $transaksi;
	  $data['grandtotal'] = $sum;

	  


	  $data['label'] = $label;
	  $this->load->view('barangMasukSuppExcel',$data);
  }
  public function excelDetNo($awal, $akhir,$master,$detil)
{
  
	
	$tgl_awal = $awal;
	$tgl_akhir = $akhir;

	$transaksi = $this->brgMasuk->view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir,$master,$detil);
    $sum = $this->brgMasuk->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);

	$tgl_awal = date('d-m-Y', strtotime($tgl_awal));
	$tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
	$label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Transaksi Beli $label.xls");
	$data['transak'] = $transaksi;
    $data['grandtotal'] = $sum;



	$data['label'] = $label;
	$this->load->view('barangMasukSuppExcel',$data);
}
public function excelDetWOBrg($awal, $akhir,$supp,$master,$detil)
{
  
	
	$tgl_awal = $awal;
	$tgl_akhir = $akhir;
$suppl = $supp;

	$transaksi = $this->brgMasuk->view_by_dateDetWithSupp($tgl_awal, $tgl_akhir,$suppl,$master,$detil);
	// $sum = $this->transBeli->fetchSumWOBrg($tgl_awal, $tgl_akhir,$suppl);

	$tgl_awal = date('d-m-Y', strtotime($tgl_awal));
	$tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
	$label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Transaksi Beli $label.xls");
	$data['transak'] = $transaksi;
	// $data['grandtotal'] = $sum;



	$data['label'] = $label;
	$this->load->view('barangMasukSuppExcel',$data);
}
public function excelDetWOSupp($awal, $akhir,$brg,$master,$detil)
{
  
	
	$tgl_awal = $awal;
	$tgl_akhir = $akhir;
	$barr = base64_decode($brg);

	$transaksi = $this->brgMasuk->view_by_dateDetWithBrg($tgl_awal, $tgl_akhir,$barr,$master,$detil);
	// $sum = $this->transBeli->fetchSumWOSupp($tgl_awal, $tgl_akhir,$barr);

	$tgl_awal = date('d-m-Y', strtotime($tgl_awal));
	$tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
	$label = 'Laporan Barang Masuk per Supplier Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Barang Masuk per Supplier  $label.xls");
	$data['transak'] = $transaksi;
	// $data['grandtotal'] = $sum;



	$data['label'] = $label;
	$this->load->view('barangMasukSuppExcel',$data);
}
function getGrandTotal()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
		$master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->brgMasuk->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalWBoth()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $barr = $this->input->post('namabrg');
        $kdsupp = $this->input->post('supp');
		$master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->brgMasuk->fetchSum($tgl_awal, $tgl_akhir, $barr,$kdsupp,$master,$detil);
		
        echo json_encode($get);
    }
    function getGrandTotalWBrg()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $barr = $this->input->post('namabrg');
		$master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->brgMasuk->fetchSumWoSupp($tgl_awal, $tgl_akhir, $barr,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalWSupp()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $kdsupp = $this->input->post('supp');
		$master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->brgMasuk->fetchSumWoBrg($tgl_awal, $tgl_akhir, $kdsupp,$master,$detil);
        echo json_encode($get);
    }
	public function today()
	{
        $data = [
            'group'     => 'Laporan Harian',
      'strat' => 2,
            'thisPage'   => 'Barang Masuk (Beli) Per Supplier / Barang'
        ];
 
		$this->page->view('barangMasukSupp',$data);
	}
	}
