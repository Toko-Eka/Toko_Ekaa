<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class TransBeli extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('UserID')) {
            redirect('auth');
        }
        $this->load->library('page');
        $this->load->model('Barang/BarangModel', 'barang');
        $this->load->model('TransaksiBeliModel', 'transBeli');
    }
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');


        $data = [
            'group'     => 'Laporan',

            'thisPage'   => 'Transaksi Pembelian'
        ];


        $this->page->view('history', $data);
    }
    public function entry()
    {
        $this->load->helper('url');
        $this->load->helper('form');


        $data = [
            'group'     => 'Transaksi',

            'thisPage'   => 'Pembelian'
        ];


        $this->page->view('history', $data);
    }
    public function viewDet()
    {
        $this->load->helper('url');
        $this->load->helper('form');

        $data = [
            'group'     => 'Transaksi Beli',
            'strat' => 1,
            'thisPage'   => 'Rinci Beli'
        ];


        $this->page->view('historyDet', $data);
    }
    public function laporan()
    {
        $this->load->helper('url');
        $this->load->helper('form');

        $data = [
            'group'     => 'Laporan',
            'strat' => 1,
            'thisPage'   => 'Rinci Beli'
        ];


        $this->page->view('historyDet', $data);
    }
    function getGrandTotalMaster()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $notaa = $this->input->post('nota');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->transBeli->fetchSumMaster($tgl_awal, $tgl_akhir, $notaa,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotal()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->transBeli->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalWBoth()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('namabrg');
        $kdsupp = $this->input->post('supp');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');

        $get = $this->transBeli->fetchSum($tgl_awal, $tgl_akhir, $kdsupp, $brg,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalWBrg()
    {

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('namabrg');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->transBeli->fetchSumWoSupp($tgl_awal, $tgl_akhir, $brg,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalWSupp()
    {
      
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $kdsupp = $this->input->post('supp');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->transBeli->fetchSumWoBrg($tgl_awal, $tgl_akhir, $kdsupp,$master,$detil);
        echo json_encode($get);
    }
   
    public function trBeliDetList($master,$detil)
    {
        $list = $this->transBeli->get_datatablesDet($master,$detil);
        $grandtotal = 0;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();
            $grandtotal += ($trJual->HARGA);
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
            $tgla = '';
            if ($trJual->TGLL == null) {
                $tgla = $trJual->TGLL;
            } else {
                $tgla = date('d-m-Y', strtotime($trJual->TGLL));
            }
            $row[] = $tgla;
 
            $role = $this->db->get_where('dbo.UserID', ['UserID' =>
            $this->session->userdata('UserID')])->row_array();
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transBeli->count_allDet($master,$detil),
            "recordsFiltered" => $this->transBeli->count_filteredDet($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
 
    public function printOne($id)
    {
        $master = $this->transBeli->getMaster($id);
        $detail = $this->transBeli->getDetailn($id);

        $data['master'] = $master;

        $data['det'] = $detail;
        $this->load->view('printSingle', $data);
    }

    public function getDetPrint($id)
    {

        $detail = $this->transBeli->getDetailn($id);



        $data['det'] = $detail;
        $this->load->view('printSingle', $data);
    }
    public function print($awal, $akhir, $notaaa)
    {
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->transBeli->view_by_date($tgl_awal, $tgl_akhir, $notaaa);
        $detail = $this->transBeli->view_by_date($tgl_awal, $tgl_akhir, $notaaa);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;

        $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('transaksiJual/historyPrint', $data);
    }
    public function printWONota($awal, $akhir)
    {
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $notaaa = '';
        $transaksi = $this->transBeli->view_by_date($tgl_awal, $tgl_akhir, $notaaa);
        $detail = $this->transBeli->view_by_date($tgl_awal, $tgl_akhir, $notaaa);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;

        $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('transaksiJual/historyPrint', $data);
    }
    public function excel($awal, $akhir, $notaaa)
    {
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $transaksi = $this->transBeli->view_by_date($tgl_awal, $tgl_akhir, $notaaa);
        $detail = $this->transBeli->view_by_date($tgl_awal, $tgl_akhir, $notaaa);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi Jual $label .xls");




        $data['transak'] = $transaksi;

        $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('historyPrintMastExcel', $data);
    }
    public function excelWONota($awal, $akhir)
    {
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $notaaa = '';
        $transaksi = $this->transBeli->view_by_date($tgl_awal, $tgl_akhir, $notaaa);
        $detail = $this->transBeli->view_by_date($tgl_awal, $tgl_akhir, $notaaa);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi Beli $label .xls");




        $data['transak'] = $transaksi;

        $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('historyPrintMastExcel', $data);
    }
    public function printDet($awal, $akhir, $supp, $brg,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $suppl = $supp;
        $barr = base64_decode($brg);
        $transaksi = $this->transBeli->view_by_dateDet($tgl_awal, $tgl_akhir, $suppl, $barr,$master,$detil);
        $sum = $this->transBeli->fetchSum($tgl_awal, $tgl_akhir, $suppl, $barr,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;




        $data['label'] = $label;
        $this->load->view('historyPrintDet', $data);
    }
    public function printDetNo($awal, $akhir,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->transBeli->view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir,$master,$detil);
        $sum = $this->transBeli->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyPrintDet', $data);
    }
    public function printDetWOBrg($awal, $akhir, $supp,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $suppl = $supp;

        $transaksi = $this->transBeli->view_by_dateDetWithSupp($tgl_awal, $tgl_akhir, $suppl,$master,$detil);
        $sum = $this->transBeli->fetchSumWOBrg($tgl_awal, $tgl_akhir, $suppl,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyPrintDet', $data);
    }
    public function printDetWOSupp($awal, $akhir, $brg,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $barr = base64_decode($brg);

        $transaksi = $this->transBeli->view_by_dateDetWithBrg($tgl_awal, $tgl_akhir, $barr,$master,$detil);
        $sum = $this->transBeli->fetchSumWOSupp($tgl_awal, $tgl_akhir, $barr,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyPrintDet', $data);
    }

    public function excelDet($awal, $akhir, $supp, $brg,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $suppl = $supp;
        $barr = base64_decode($brg);
        $transaksi = $this->transBeli->view_by_dateDet($tgl_awal, $tgl_akhir, $suppl, $barr,$master,$detil);
        $sum = $this->transBeli->fetchSum($tgl_awal, $tgl_akhir, $suppl, $barr,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan rinci Beli $label.xls");
        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;




        $data['label'] = $label;
        $this->load->view('historyDetExcel', $data);
    }
    public function excelDetNo($awal, $akhir,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->transBeli->view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir,$master,$detil);
        $sum = $this->transBeli->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan rinci Beli $label.xls");
        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyDetExcel', $data);
    }
    public function excelDetWOBrg($awal, $akhir, $supp,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $suppl = $supp;

        $transaksi = $this->transBeli->view_by_dateDetWithSupp($tgl_awal, $tgl_akhir, $suppl,$master,$detil);
        $sum = $this->transBeli->fetchSumWOBrg($tgl_awal, $tgl_akhir, $suppl,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan rinci Beli $label.xls");
        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyDetExcel', $data);
    }
    public function  excelDetWOSupp($awal, $akhir, $brg,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $barr = base64_decode($brg);
        $transaksi = $this->transBeli->view_by_dateDetWithBrg($tgl_awal, $tgl_akhir, $barr,$master,$detil);
        $sum = $this->transBeli->fetchSumWOSupp($tgl_awal, $tgl_akhir, $barr,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan rinci Beli $label.xls");
        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyDetExcel', $data);
    }
    public function trBeliList()
    {
        $grandtotal = 0;
        $list = $this->transBeli->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();
            $row[] = '<i id="icnsubgrid' . ($no - 1) . '" class="fa fa-plus" aria-hidden="true"></i>';
            $row[] = $trJual->NOTA;
            $row[] =   date('d-m-Y', strtotime($trJual->TGL));

            $row[] = NUMBER_FORMAT($trJual->JMLBRG);
            $row[] = NUMBER_FORMAT($trJual->TOTAL);

            $unpaid = '';
            if ($trJual->PAID == 0) {
                $unpaid = '<span class ="badge badge-sm badge-danger">Belum dibayar</span>';
            } else {
                $unpaid = '<span class ="badge badge-sm badge-success">Sudah dibayar</span>';
            }

            $row[] = $unpaid;

            // $row[] = $trJual->KET1;
            $grandtotal += ($trJual->TOTAL);
            // $row[] = $grandtotal;
            $row[] = $trJual->KASIR;

            $role = $this->db->get_where('dbo.UserID', ['UserID' =>
            $this->session->userdata('UserID')])->row_array();
            //              if  ($role['AccessGrp'] == 'KASIR') { 
            //              //add html for action
           
            //   }
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transBeli->count_all(),
            "recordsFiltered" => $this->transBeli->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function getTransakJualDetil()
    {
        $result = $this->transBeli->getTransJualDetil($_POST['id']);
        echo json_encode($result);
    }
    public function BarangMasukPerSupp()
    {
        $data['userSes'] = $this->db->get_where('dbo.UserID', ['UserID' =>
        $this->session->userdata('UserID')])->row_array();

        // $data['total_user'] = $this->auth_model->rowuser();
        // $data['total_meja'] = $this->Meja_Model->rowmeja();
        // $data['total_menu'] = $this->Menu_Model->rowmenu();
        // $data['total_tr'] = $this->invoice_Model->rowtr();
        // $data['history'] = $this->invoice_Model->tampil_history();



        $this->page->view('barangMasukSupp');
    }

    public function today()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data['userSes'] = $this->db->get_where('dbo.UserID', ['UserID' =>
        $this->session->userdata('UserID')])->row_array();

        $data = [
            'group'     => 'Laporan',
            'strat' => 2,
            'thisPage'   => 'Rinci Beli'
        ];


        $this->page->view('historyDet', $data);
    }
}
