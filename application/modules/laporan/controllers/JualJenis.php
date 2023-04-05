<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JualJenis extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('UserID')) {
            redirect('auth');
        }
        $this->load->library('page');
        $this->load->model('Barang/BarangModel', 'brg');

        $this->load->model('JualJenisModel', 'jenisJual');
      
    }
    
function getGrandTotalKanvas()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $barr = $this->input->post('namabrg');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');

        $get = $this->jenisJual->fetchSumKanvas($tgl_awal, $tgl_akhir, $barr,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalOlshop()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $barr = $this->input->post('namabrg');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');

        $get = $this->jenisJual->fetchSumOlshop($tgl_awal, $tgl_akhir, $barr,$master,$detil);
        echo json_encode($get);
    }
    function getGrandTotalProgram()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $barr = $this->input->post('namabrg');
        $master = $this->input->post('master');
        $detil = $this->input->post('detil');
        $get = $this->jenisJual->fetchSumProgram($tgl_awal, $tgl_akhir, $barr,$master,$detil);
        echo json_encode($get);
    }
    public function kanvas()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan',
      'strat' => 1,
            'thisPage'   => 'Penjualan Jenis Kanvas'
        ];

        $this->page->view('jualKanvas',$data);
    }
    public function kanvasToday()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan Harian',
      'strat' => 2,
            'thisPage'   => 'Penjualan Jenis Kanvas'
        ];

        $this->page->view('jualKanvas',$data);
    }
    public function kanvasList($master,$detil)
    {
        $list = $this->jenisJual->get_datatables($master,$detil);
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
            "recordsFiltered" => $this->jenisJual->count_filtered($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function kanvasPrint($awal, $akhir, $notaaa,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repKanvas($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualKanvasPrint', $data);
    }
    public function kanvasPrintWONota($awal, $akhir,$master,$detil)
    {
        $notaaa = '';
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repKanvas($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualKanvasPrint', $data);
    }
    public function kanvasExcel($awal, $akhir, $notaaa,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repKanvas($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi Jual Kanvas $label.xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualKanvasExcel', $data);
    }
    public function kanvasExcelWONota($awal, $akhir,$master,$detil)
    {
        $notaaa = '';
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repKanvas($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi Jual Kanvas $label.xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualKanvasExcel', $data);
    }
    public function program()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan',
      'strat' => 1,
            'thisPage'   => 'Penjualan Jenis Program'
        ];

        $this->page->view('jualProgram',$data);
    }
    public function programToday()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Laporan Harian',
      'strat' => 2,
            'thisPage'   => 'Penjualan Jenis Program'
        ];

        $this->page->view('jualProgram',$data);
    }
    public function programList($master,$detil)
    {
        $list = $this->jenisJual->get_datatablesPr($master,$detil);
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
            // "recordsTotal" => $this->jenisJual->count_allDet(),
            "recordsFiltered" => $this->jenisJual->count_filteredDet($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function programPrint($awal, $akhir, $notaaa,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repProgram($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualProgramPrint', $data);
    }
    public function programPrintWONota($awal, $akhir,$master,$detil)
    {
$notaaa = '';
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repProgram($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualProgramPrint', $data,$master,$detil);
    }
    public function programExcel($awal, $akhir, $notaaa,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repProgram($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi Jenis Program $label.xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualProgramExcel', $data);
    }
    public function programExcelWONota($awal, $akhir,$master,$detil)
    {
$notaaa = '';
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repProgram($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi Jenis Program $label.xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualProgramExcel', $data);
    }
    public function olshop()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data['userSes'] = $this->db->get_where('dbo.UserID', ['UserID' =>
        $this->session->userdata('UserID')])->row_array();
        $data = [
            'group'     => 'Laporan',
      'strat' => 1 ,
            'thisPage'   => 'Penjualan Jenis Olshop'
        ];

          $this->page->view('jualOlshop',$data);
    }
    public function olshopToday()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data['userSes'] = $this->db->get_where('dbo.UserID', ['UserID' =>
        $this->session->userdata('UserID')])->row_array();
        $data = [
            'group'     => 'Laporan Harian',
      'strat' => 2 ,
            'thisPage'   => 'Penjualan Jenis Olshop'
        ];

          $this->page->view('jualOlshop',$data);
    }
    public function olshopList($master,$detil)
    {
        $list = $this->jenisJual->get_datatablesOl($master,$detil);
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
            // "recordsTotal" => $this->jenisJual->count_allDet(),
            "recordsFiltered" => $this->jenisJual->count_filteredOl($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function olshopPrint($awal, $akhir, $notaaa,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repOlshop($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualOlshopPrint', $data);
    }
    public function olshopPrintWONota($awal, $akhir,$master,$detil)
    {
        $notaaa = '';
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repOlshop($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualOlshopPrint', $data);
    }
    public function olshopExcel($awal, $akhir, $notaaa,$master,$detil)
    {

        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repOlshop($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi Jenis Olshop $label.xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualOlshopExcel', $data);
    }
    public function olshopExcelWONota($awal, $akhir,$master,$detil)
    {
        $notaaa = '';
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->jenisJual->repOlshop($tgl_awal, $tgl_akhir, $notaaa,$master,$detil);
        // $sum = $this->jenisJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);
      
        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Transaksi Jenis Olshop $label.xls");
        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('jualOlshopExcel', $data);
    }
}