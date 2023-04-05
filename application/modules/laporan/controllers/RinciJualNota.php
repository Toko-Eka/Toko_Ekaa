<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RinciJualNota extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('UserID')) {
            redirect('auth');
        }
        $this->load->library('page');
        $this->load->model('Barang/BarangModel', 'brg');
        $this->load->model('Penjualan/TransaksiJualModel', 'transJual');
       
        $this->load->model('RinciJualModel', 'rinciJual');
      
    }
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Transaksi Jual(H-1)',
            'strat' =>  1,
            'thisPage'   => 'Rinci Jual'
        ];



        $this->page->view('detPerNota',$data);

     
    }
    public function today()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan Harian',
            'strat' =>  2,
            'thisPage'   => 'Rinci Jual Per Nota'
        ];



        $this->page->view('detPerNota',$data);

     
    }
public function detPerNotaList($master,$detil)
    {
        $list = $this->rinciJual->get_datatables($master,$detil);
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
            "recordsFiltered" => $this->rinciJual->count_filtered($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
  
    public function detPerNotaPrint($awal, $akhir,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->rinciJual->RepDetPerNota($tgl_awal, $tgl_akhir,$master,$detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('detPerNotaPrint', $data);
    }
    public function detPerNotaPrintSearch($awal, $akhir,$value,$master,$detil)
    {
        $brg = base64_decode($value);
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->rinciJual->RepDetPerNotaSearch($tgl_awal, $tgl_akhir,$brg,$master,$detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('detPerNotaPrint', $data);
    }
    public function detPerNotaExcel($awal, $akhir,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->rinciJual->RepDetPerNota($tgl_awal, $tgl_akhir,$master,$detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");

        header("Content-Disposition: attachment; filename=Laporan Transaksi Jual $label .xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('detPerNotaExcel', $data);
    }
    public function detPerNotaExcelSearch($awal, $akhir,$value,$master,$detil)
    {
        $brg = base64_decode($value);
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->rinciJual->RepDetPerNotaSearch($tgl_awal, $tgl_akhir,$brg,$master,$detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");

        header("Content-Disposition: attachment; filename=Laporan Transaksi Jual $label .xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('detPerNotaExcel', $data);
    }
    function getGrandTotal()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');

        $get = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);
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

        $get = $this->transJual->fetchSum($tgl_awal, $tgl_akhir , $brg , $kdsupp,$master,$detil );
        echo json_encode($get);
    }
    function getGrandTotalWBrg()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('namabrg');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->transJual->fetchSumWoSupp($tgl_awal, $tgl_akhir, $brg,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalWSupp()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $kdsupp = $this->input->post('supp');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->transJual->fetchSumWoBrg($tgl_awal, $tgl_akhir, $kdsupp,$master,$detil);
        echo json_encode($get);
    }
}