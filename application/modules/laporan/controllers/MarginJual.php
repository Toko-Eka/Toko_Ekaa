<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MarginJual extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('UserID')) {
            redirect('auth');
        }
        $this->load->library('page');
        $this->load->model('Barang/BarangModel', 'brg');

        $this->load->model('MarginJualModel', 'margin');
    }

    public function index()
    {

        $this->load->helper('url');
        $this->load->helper('form');

        $data = [
            'group'     => 'Laporan',
            'strat' => 1,
            'thisPage'   => 'Margin Penjualan'
        ];
        $this->page->view('marginPenjualan', $data);
    }

    public function margiinList($master, $detil)
    {
        $list = $this->margin->get_datatables($master, $detil);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();
            $row[] = $trJual->NAMABRG;
            $row[] = NUMBER_FORMAT($trJual->JMLBRG);
            $row[] = NUMBER_FORMAT($trJual->HBT);
            $row[] = NUMBER_FORMAT($trJual->MODAL);
            $row[] = NUMBER_FORMAT($trJual->TOTAL);
            $row[] = NUMBER_FORMAT($trJual->MARGIN);
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            // "recordsTotal" => $this->transJual->count_allDet(),
            "recordsFiltered" => $this->margin->count_filtered($master, $detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function marginGrandTotal()
    {


        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = '';
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->margin->fetchSum($tgl_awal, $tgl_akhir, $brg, $master, $detil);
        echo json_encode($get);
    }
    public function marginGrandTotalBrg()
    {

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('namabrg');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->margin->fetchSum($tgl_awal, $tgl_akhir, $brg, $master, $detil);
        echo json_encode($get);
    }
    public function marginGrandTotalSupp()
    {

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = '';
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $supp = $this->input->post('kdsup');
        $get = $this->margin->fetchSumBoth($tgl_awal, $tgl_akhir, $brg, $supp, $master, $detil);
        echo json_encode($get);
    }
    public function marginGrandTotalBoth()
    {

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $brg = $this->input->post('namabrg');
        $supp = $this->input->post('kdsup');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->margin->fetchSumBoth($tgl_awal, $tgl_akhir, $brg, $supp, $master, $detil);
        echo json_encode($get);
    }
    public function marginPrint($tgl_awal, $tgl_akhir, $master, $detil)
    {


        $barr = '';
        // $barr = base64_decode($barr);

        $transaksi = $this->margin->repMargin($tgl_awal, $tgl_akhir, $barr, $master, $detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('marginPenjualanPrint', $data);
    }
    public function marginPrintBrg($awal, $akhir, $barr, $master, $detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $barr = base64_decode($barr);
        $transaksi = $this->margin->repMargin($tgl_awal, $tgl_akhir, $barr, $master, $detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('marginPenjualanPrint', $data);
    }
    public function marginPrintSupp($awal, $akhir, $supp, $master, $detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $barr = '';
        $transaksi = $this->margin->repMarginSupp($tgl_awal, $tgl_akhir, $supp, $barr, $master, $detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('marginPenjualanPrint', $data);
    }
    public function marginPrintBoth($awal, $akhir, $supp, $barr, $master, $detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $barr = base64_decode($barr);
        $transaksi = $this->margin->repMarginSupp($tgl_awal, $tgl_akhir, $supp, $barr, $master, $detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('marginPenjualanPrint', $data);
    }
    public function marginExcel($awal, $akhir, $master, $detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $barr = '';
        $transaksi = $this->margin->repMargin($tgl_awal, $tgl_akhir, $barr, $master, $detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;


        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Margin Penjualan $label .xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;
        $data['label'] = $label;
        $this->load->view('marginPenjualanExcel', $data);
    }
    public function marginExcelBrg($awal, $akhir, $barr, $master, $detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->margin->repMargin($tgl_awal, $tgl_akhir, $barr, $master, $detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;


        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Margin Penjualan $label .xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;
        $data['label'] = $label;
        $this->load->view('marginPenjualanExcel', $data);
    }
    public function marginExcelSupp($awal, $akhir, $supp, $master, $detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $barr = '';
        $transaksi = $this->margin->repMarginSupp($tgl_awal, $tgl_akhir, $supp, $barr, $master, $detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Margin Penjualan $label .xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;
        $data['label'] = $label;
        $this->load->view('marginPenjualanExcel', $data);
    }
    public function marginExcelBoth($awal, $akhir, $supp, $barr, $master, $detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->margin->repMarginSupp($tgl_awal, $tgl_akhir, $supp, $barr, $master, $detil);
        // $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;


        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Margin Penjualan $label .xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;
        $data['label'] = $label;
        $this->load->view('marginPenjualanExcel', $data);
    }
}
