<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('UserID')) {
            redirect('auth');
        }
        $this->load->model('BarangModel', 'barang');
    }
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = [
            'group'     => 'Inventory',

            'thisPage'   => 'Barang'
        ];
        $this->page->view('v_master', $data);
    }
    public function brgList()
    {
        $list = $this->barang->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brg) {

            $no++;
            $row = array();
            $row[] = $brg->KDBRG;
            $row[] = $brg->JENIS;
            $row[] = $brg->NAMABRG;
            $row[] = $brg->KDSUP;
            $stock = '';
            if ($brg->AKHIR == 0) {
                $stock = '<span class ="badge badge-sm badge-danger">HABIS</span>';
                $row[] = $stock;
            } else {
                $row[] = $brg->AKHIR;
            }
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editBarg(' . "'" . $brg->KDBRG . "'" . ')"><i class="fa fa-pen-to-square"></i> </a>
                   <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del(' . "'" . $brg->KDBRG . "'" . ')"><i class="fa fa-trash"></i> </a> ';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->barang->count_all(),
            "recordsFiltered" => $this->barang->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function brgListRep()
    {
        $list = $this->barang->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brg) {
            $no++;
            $row = array();
            $row[] = $brg->KDBRG;
            $row[] = $brg->JENIS;
            $row[] = $brg->NAMABRG;
            $row[] = $brg->KDSUP;
            $stock = '';
            if ($brg->AKHIR == 0) {
                $stock = '<span class ="badge badge-sm badge-danger">HABIS</span>';
                $row[] = $stock;
            } else {
                $row[] = $brg->AKHIR;
            }

       
            $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Print Kartu Stok" onclick="select(' . "'" . $brg->KDBRG . "'" . ',' . "'" . $brg->NAMABRG . "'" . ',' . "'" . $brg->KDSUP . "'" . ',' . "'" . $brg->AWAL . "'" . ',' . "'" . $brg->AKHIR . "'" . ',' . "'" . $brg->MASUK . "'" . ',' . "'" . $brg->JUAL . "'" . ',' . "'" . $brg->HET . "'" . ',' . "'" . $brg->HBT . "'" . ')">Pilih</a>';
   
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->barang->count_all(),
            "recordsFiltered" => $this->barang->count_filtered(),
            "data" => $data,
        );
      
        echo json_encode($output);
    }
    public function brgPoList()
    {
        $list = $this->transPo->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brg) {

            $no++;
            $row = array();

            $row[] = $brg->KDBRG;

            $row[] = $brg->NAMABRG;
            $row[] = $brg->KDSUP;
            $stock = '';
            if ($brg->AKHIR == 0) {
                $stock = '<span class ="badge badge-sm badge-danger">HABIS</span>';
                $row[] = $stock;
            } else {
                $row[] = $brg->AKHIR;
            }
            $row[] = $brg->MASUK;
            $row[] = $brg->JUAL;
            $row[] = $brg->MAXOR;

           
            //  $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Print Kartu Stok" onclick="select('."'".$brg->KDBRG."'".','."'".$brg->NAMABRG."'".','."'".$brg->KDSUP."'".')">Pilih</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->barang->count_all(),
            "recordsFiltered" => $this->barang->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addBrg()
    {
        $data = array(
            'KDBRG' => $this->input->post('KDBRG'),

            'NAMABRG' => $this->input->post('NAMABRG'),
            'JENIS' => $this->input->post('JENIS'),
            'KDSUP' => $this->input->post('KDSUP'),
            'AKHIR' => $this->input->post('AKHIR'),

        );
        $insert = $this->barang->save($data);
        echo json_encode(array("status" => TRUE));
    }
    public function editBrg($id)
    {
        $data = $this->barang->get_by_id($id);
        echo json_encode($data);
    }
    public function updateBrg()
    {
        $data = array(
            'KDBRG' => $this->input->post('KDBRG'),
            'JENIS' => $this->input->post('JENIS'),
            'NAMABRG' => $this->input->post('NAMABRG'),
            'KDSUP' => $this->input->post('KDSUP'),
            'AKHIR' => $this->input->post('AKHIR'),

        );
        $this->barang->update(array('KDBRG' => $this->input->post('KDBRG')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delBrg($id)
    {
        $this->barang->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    public function search()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->barang->search($postData);

        echo json_encode($data);
    }
    public function searchJen()
    {
        // POST data
        $postJen = $this->input->post();

        // Get data
        $data = $this->barang->fetchJen($postJen);

        echo json_encode($data);
    }
    public function searchBrg()
    {
        // POST data
        $postBrg = $this->input->post();

        // Get data
        $data = $this->barang->fetchBrg($postBrg);

        echo json_encode($data);
    }
}
