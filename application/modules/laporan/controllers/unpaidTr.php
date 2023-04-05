<?php
defined('BASEPATH') or exit('No direct script access allowed');

class unpaidTr extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('UserID')) {
            redirect('auth');
        }
        $this->load->library('page');
        $this->load->model('Barang/BarangModel', 'brg');
 
        $this->load->model('UnpaidTrModel', 'unpaidTr');

    }
public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan',
'strat' => 1,
            'thisPage'   => 'Penjualan Belum Di Bayar'
        ];

        $this->page->view('unpaidTr',$data);
    }
    public function today()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan Harian',
            'strat' => 2,
            'thisPage'   => 'Penjualan Belum Di Bayar'
        ];

        $this->page->view('unpaidTr',$data);
    }
    public function unpaidTrList($master,$detil)
    {
        $list = $this->unpaidTr->get_datatables($master,$detil);
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


            $role = $this->db->get_where('dbo.UserID', ['UserID' =>
            $this->session->userdata('UserID')])->row_array();
          
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            // "recordsTotal" => $this->transJual->count_allDet(),
            "recordsFiltered" => $this->unpaidTr->count_filtered($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    function getGrandTotalUnpaid()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');

        $get = $this->unpaidTr->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);
        echo json_encode($get);
    }

    function getGrandTotalUnpaidbrg()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('namabrg');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->unpaidTr->fetchSumWoSupp($tgl_awal, $tgl_akhir, $brg,$master,$detil);
        echo json_encode($get);
    }
   
   
    public function unpaidPrint($awal, $akhir,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->unpaidTr->repUnpaid($tgl_awal, $tgl_akhir,$master,$detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('unpaidTrPrint', $data);
    }
    public function unpaidExcel($awal, $akhir,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->unpaidTr->repUnpaid($tgl_awal, $tgl_akhir,$master,$detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi yang belum dibayar $label.xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('unpaidTrExcel', $data);
    }
}