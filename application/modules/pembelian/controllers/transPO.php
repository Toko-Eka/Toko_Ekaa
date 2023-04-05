<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transPO extends CI_Controller {
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
        $this->load->model('TransaksiBeliModel', 'transBeli');
		$this->load->model('TransPoModel', 'transPo');

		// if($this->session->userdata('status') != "login"){

		// 	redirect(base_url("login"));
		// }

	}
    public function index()
	{
	
		$data = [
            'group'     => 'Transaksi',
            'strat' =>  1,
            'thisPage'   => 'Purchase Order'
        ];
 

		$this->page->view('trpo',$data);
		
	}
	public function add()
	{
	
		$data = [
            'group'     => 'Transaksi',
            'strat' =>  2,
            'thisPage'   => 'Entry PO'
        ];
 

		$this->page->view('poTrans',$data);
		
	}
    public function getDetail()
    {
        $result = $this->transPo->getDetail($_POST['id']);
        echo json_encode($result);
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
            $row[] = $brg->TERJUAL;
            $row[] = $brg->MAXOR;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transPo->count_all(),
            // "recordsFiltered" => $this->transPo->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function poList($stat)
    {
        $list = $this->transPo->get_datatablesLoad();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brg) {

            $no++;
            $row = array();
            if ($stat == 1)
            {
                $row[] = '<i id="icnsubgrid' . ($no - 1) . '" class="fa fa-plus" aria-hidden="true"></i>';
            }
            $row[] = $brg->nopo;
			$row[] = $brg->kdsup;
            $row[] = $brg->supplier;
            $row[] = $brg->flag2;
        if ($stat == 1)
     {
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="pilih" onclick="edit(' . "'" . $brg->nopo . "'" . ')"><i class="fa fa-pen-to-square"></i></a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="pilih" onclick="del(' . "'" . $brg->nopo . "'" . ')"><i class="fa fa-trash"></i></a>'; 
     }else{
        $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="pilih" onclick="loadNotaa(' . "'" . $brg->nopo . "'" . ')">Pilih</a>';
       
     }
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transPo->count_allLoad(),
            "recordsFiltered" => $this->transPo->count_filteredLoad(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	function loadNota()
    {
        $id = $this->input->post('notaa');

      
        $get = $this->transPo->load($id);
        echo json_encode($get);
    }
    function barcode()
    {
        $id = $this->input->post('kode');

      
        $get = $this->transPo->scanBar($id);
        echo json_encode($get);
    }
	function getBarangs()
    {
        $id = $this->input->post('idall');

      
        $get = $this->transBeli->getAll($id);
        echo json_encode($get);
    }
	public function getCode(){
		$stat = $this->input->post('true');
		
	$res = $this->transBeli->generateCode($stat);
	echo $res;
	}
	public function getNota(){
		$stat = $this->input->post('true');
		
	$res = $this->transBeli->generateNota($stat);
	echo $res;
	}
	public function addPO()
    {
        $data = array(
			'nopo' =>  $this->input->post('nompo'),
            'kdsup' => $this->input->post('KDSUP'),
            'flag2' => $this->input->post('flag2'),
            'supplier' => $this->input->post('supplier'),
           

        );
        $insert = $this->transBeli->save($data);
		$nopo = $_POST['nompo']; 
		$kd = $_POST['KDBRG']; 
		$jmorder = $_POST['JMLBRG']; 
	
		$nama = $_POST['NAMABRG']; 
		$hargaj = $_POST['HARGA']; 
		$HBT = $_POST['HBT']; 
		$jmmasuk = $_POST['JMLMSK']; 
		$data2 = array();
		
		$index = 0; 
		if ($kd[0] !== null) 
			{
		foreach($kd as $kdbar){ 
			
		$data = [
			'NOPO'=>$nopo,
			'KDBRG'=>substr($kdbar,1),
			'NAMABRG'=>substr($nama[$index],1),  
			'JMLBRG'=>$jmorder[$index],  
			'HARGA'=>$hargaj[$index],  
			'HBT'=>$HBT[$index],  
			'HBTBARU'=>$HBT[$index],  
			'JMLMSK'=>$jmmasuk[$index],  
		];
		$insert = $this->db->insert('Trpodetil', $data);
        if ($insert) {
			$index++;
        }
		
		}
	}
        echo json_encode(array("status" => TRUE));
		$this->session->set_flashdata('msg', 'Transaksi PO Berhasil Ditambah');
		redirect('pembelian/transPo');
    }
	public function search()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->transPo->search($postData);

        echo json_encode($data);
    }
	}
