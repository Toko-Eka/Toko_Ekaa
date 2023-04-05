<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransJual extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('UserID')) {
            redirect('auth');
        }
        $this->load->library('page');
        $this->load->model('Barang/BarangModel', 'brg');
        $this->load->model('TransaksiJualModel', 'transJual');
    
    }
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        
        $data = [
            'group'     => 'History Jual',
            'strat' =>  1,
            'thisPage'   => 'Riwayat Transaksi Jual'
        ];


      
        $this->page->view('history',$data);

    }
    function getGrandTotalMaster()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $notaa = $this->input->post('nota');
      
        $get = $this->transJual->fetchSumMaster($tgl_awal, $tgl_akhir,$notaa);
        echo json_encode($get);
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

        $get = $this->transJual->fetchSum($tgl_awal, $tgl_akhir , $brg , $kdsupp ,$master,$detil);
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
   
   
    
    public function print($awal, $akhir,$notaaa)
    {
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->transJual->view_by_date($tgl_awal, $tgl_akhir,$notaaa);
        $detail = $this->transJual->view_by_date($tgl_awal, $tgl_akhir,$notaaa);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;

        $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('historyPrint', $data);
    }
    public function printWONota($awal, $akhir)
    {
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $notaaa = '';
        $transaksi = $this->transJual->view_by_date($tgl_awal, $tgl_akhir,$notaaa);
        $detail = $this->transJual->view_by_date($tgl_awal, $tgl_akhir,$notaaa);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;

        $data['det'] = $detail;


        $data['label'] = $label;
        $this->load->view('historyPrint', $data);
    }
    public function excel($awal, $akhir, $notaaa)
    {
        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $transaksi = $this->transJual->view_by_date($tgl_awal, $tgl_akhir,$notaaa);
        $detail = $this->transJual->view_by_date($tgl_awal, $tgl_akhir,$notaaa);

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
        $transaksi = $this->transJual->view_by_date($tgl_awal, $tgl_akhir,$notaaa);
        $detail = $this->transJual->view_by_date($tgl_awal, $tgl_akhir,$notaaa);

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
    public function trJualList()
    {
        $grandtotal = 0;
        $list = $this->transJual->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trJual) {
            $no++;
            $row = array();
            $row[] = '<i id="icnsubgrid' . ($no - 1) . '" class="fa fa-plus" aria-hidden="true"></i>';
            $row[] = $trJual->NOTA;

            $row[] =   date('d-m-Y', strtotime($trJual->TGL));

            $row[] = NUMBER_FORMAT($trJual->JMLBRG);
            $row[] = NUMBER_FORMAT($trJual->TOTAL, 0, ",", ".");
            // $grandtotal +=($trJual->TOTAL);
            // $row[] = $grandtotal;
            $unpaid = '';
            if ($trJual->PAID == 0) {
                $unpaid = '<span class ="badge badge-sm badge-danger">Belum dibayar</span>';
            } else {
                $unpaid = '<span class ="badge badge-sm badge-success">Sudah dibayar</span>';
            }

            $row[] = $unpaid;

            // $row[] = $trJual->KET1;
            $row[] = $trJual->KASIR;

            $role = $this->db->get_where('dbo.UserID', ['UserID' =>
            $this->session->userdata('UserID')])->row_array();
            //              if  ($role['AccessGrp'] == 'KASIR') { 
            //              //add html for action
            $row[] = '';
            //   }
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transJual->count_all(),
            "recordsFiltered" => $this->transJual->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function viewDet()
    {
        $this->load->helper('url');
        $this->load->helper('form');
     


        $data = [
            'group'     => 'History Jual',
            'strat' =>  1,
            'thisPage'   => 'Rinci Jual'
        ];


        
        $this->page->view('historyDet',$data);
    }
    public function laporan()
    {
        $this->load->helper('url');
        $this->load->helper('form');
     


        $data = [
            'group'     => 'Laporan',
            'strat' =>  1,
            'thisPage'   => 'Rinci Jual'
        ];


        
        $this->page->view('historyDet',$data);
    }
    public function printDet($awal, $akhir, $supp, $brg,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $suppl = $supp;
        $barr = base64_decode($brg);
        $transaksi = $this->transJual->view_by_dateDet($tgl_awal, $tgl_akhir, $suppl, $barr,$master,$detil);
        $sum = $this->transJual->fetchSum($tgl_awal, $tgl_akhir, $suppl, $barr,$master,$detil);

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

        $transaksi = $this->transJual->view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir,$master,$detil);
        $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);

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

        $transaksi = $this->transJual->view_by_dateDetWithSupp($tgl_awal, $tgl_akhir, $suppl,$master,$detil);
        // $sum = $this->transJual->fetchSumWOBrg($tgl_awal, $tgl_akhir, $suppl);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        // $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyPrintDet', $data);
    }
    public function printDetWOSupp($awal, $akhir, $brg,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $barr = base64_decode($brg);

        $transaksi = $this->transJual->view_by_dateDetWithBrg($tgl_awal, $tgl_akhir, $barr,$master,$detil);
        $sum = $this->transJual->fetchSumWOSupp($tgl_awal, $tgl_akhir, $barr,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyPrintDet', $data);
    }
    // public function pdfDet($awal, $akhir, $supp, $brg)
    // {


    //     $tgl_awal = $awal;
    //     $tgl_akhir = $akhir;
    //     $suppl = $supp;
    //     $barr = base64_decode($brg);
    //     $transaksi = $this->transJual->view_by_dateDet($tgl_awal, $tgl_akhir, $suppl, $barr);
    //     $sum = $this->transJual->fetchSum($tgl_awal, $tgl_akhir, $suppl, $barr);

    //     $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
    //     $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
    //     $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
    //     header("Content-type:application/pdf");

    //     // It will be called downloaded.pdf
    //     header("Content-Disposition:attachment;filename=\"Laporan Transaksi Jual $label.pdf\"");

    //     // The PDF source is in original.pdf
    //     readfile("original.pdf");

    //     $data['transak'] = $transaksi;
    //     $data['grandtotal'] = $sum;




    //     $data['label'] = $label;
    //     $this->load->view('historyDetExcel', $data);
    // }
    // public function pdfDetNo($awal, $akhir)
    // {


    //     $tgl_awal = $awal;
    //     $tgl_akhir = $akhir;

    //     $transaksi = $this->transJual->view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir);
    //     $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir);


    //     $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
    //     $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
    //     $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;

    //     header("Content-type:application/pdf");

    //     // It will be called downloaded.pdf
    //     header("Content-Disposition:attachment;filename=\"downloaded.pdf\"");

    //     // The PDF source is in original.pdf
    //     readfile("original.pdf");
    //     ob_clean();
    //     flush();


    //     $data['transak'] = $transaksi;
    //     $data['grandtotal'] = $sum;

    //     $data['label'] = $label;
    //     $this->load->view('historyDetPdf', $data);
    // }
    public function excelDet($awal, $akhir, $supp, $brg,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;
        $suppl = $supp;
        $barr = base64_decode($brg);
        $transaksi = $this->transJual->view_by_dateDet($tgl_awal, $tgl_akhir, $suppl, $barr,$master,$detil);
        $sum = $this->transJual->fetchSum($tgl_awal, $tgl_akhir, $suppl, $barr,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan rinci transaksi Jual $label.xls");
        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;




        $data['label'] = $label;
        $this->load->view('historyDetExcel', $data);
    }
    public function excelDetNo($awal, $akhir,$master,$detil)
    {


        $tgl_awal = $awal;
        $tgl_akhir = $akhir;

        $transaksi = $this->transJual->view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir,$master,$detil);
        $sum = $this->transJual->fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan rinci Jual $label.xls");
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

        $transaksi = $this->transJual->view_by_dateDetWithSupp($tgl_awal, $tgl_akhir, $suppl,$master,$detil);
        $sum = $this->transJual->fetchSumWOBrg($tgl_awal, $tgl_akhir, $suppl,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan rinci Jual $label.xls");
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

        $transaksi = $this->transJual->view_by_dateDetWithBrg($tgl_awal, $tgl_akhir, $barr,$master,$detil);
        $sum = $this->transJual->fetchSumWOSupp($tgl_awal, $tgl_akhir, $barr,$master,$detil);

        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));
        $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan rinci Jual $label.xls");
        $data['transak'] = $transaksi;
        $data['grandtotal'] = $sum;



        $data['label'] = $label;
        $this->load->view('historyDetExcel', $data);
    }
    public function trJualDetList($master,$detil)
    {
        $list = $this->transJual->get_datatablesDet($master,$detil);
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

            $role = $this->db->get_where('dbo.UserID', ['UserID' =>
            $this->session->userdata('UserID')])->row_array();
            //              if  ($role['AccessGrp'] == 'KASIR') { 
            //              //add html for action

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            // "recordsTotal" => $this->transJual->count_allDet(),
            "recordsFiltered" => $this->transJual->count_filteredDet($master,$detil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function getTransakJualDetil()
    {
        $result = $this->transJual->getTransJualDetil($_POST['id']);
        echo json_encode($result);
    }

    public function addNew()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data['userSes'] = $this->db->get_where('dbo.UserID', ['UserID' =>
        $this->session->userdata('UserID')])->row_array();




        $this->load->view('temp/v_header', $data);
        $this->load->view('master', $data);
        $this->load->view('temp/v_footer', $data);
    }
    public function today()
    {
        $this->load->helper('url');
        $this->load->helper('form');
      
        $data = [
            'group'     => 'Transaksi Jual(H-1)',
            'strat' =>  2,
            'thisPage'   => 'Riwayat Transaksi Jual (Hari Ini)'
        ];

        $this->page->view('historyDet',$data);
        // $this->load->view('temp/v_footer', $data);
    }
}
