<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {
	function  __construct(){
		parent::__construct();
		if ( ! $this->session->userdata('UserID'))
        { 
            redirect('auth');
        }
      

		$this->load->model('SupplierModel','supplier');
	
	}
    public function index(){
        $data = [
            'group'     => 'Inventory',
      
            'thisPage'   => 'Supplier'
        ];
        $this->page->view('v_suppl',$data);
     } 
    
   
     public function suppList()
     {
         $list = $this->supplier->get_datatables();
         $data = array();
         $no = $_POST['start'];
         foreach ($list as $supp) {
             $no++;
             $row = array();
             $row[] = $supp->KDSUP;
             $row[] = $supp->NAMA;
             $faktur = '';
             if ($supp->FAKTUR == 0) {
              $faktur ='<span class ="badge badge-sm badge-danger">Tidak</span>';
             }
             else {
                $faktur ='<span class ="badge badge-sm badge-success">Iya</span>';
             }
             $row[] = $faktur;
             $fx='';
             if ($supp->FxOrder == 0) {
                $fx ='<span class ="badge badge-sm badge-danger">Tidak</span>';
               }
               else {
                  $fx ='<span class ="badge badge-sm badge-success">Iya</span>';
               }
             $row[] = $fx;
           
  
             //add html for action
             $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editSup('."'".$supp->KDSUP."'".')"><i class="fa fa-pen"></i> </a>
                   <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$supp->KDSUP."'".')"><i class="fa fa-trash"></i></a>';
  
             $data[] = $row;
         }
       
     
         $output = array(
                         "draw" => $_POST['draw'],
                         "recordsTotal" => $this->supplier->count_all(),
                         "recordsFiltered" => $this->supplier->count_filtered(),
                         "data" => $data,
                         
                 );
         //output to json format
         echo json_encode($output);
     }
     public function addSupp()
    {
        $data = array(
                'KDSUP' => $this->input->post('KDSUP'),
                'NAMA' => $this->input->post('NAMA'),
                'FAKTUR' => $this->input->post('FAKTUR'),
                'FxOrder' => $this->input->post('FxOrder'),
              
            );
        $insert = $this->supplier->save($data);
        echo json_encode(array("status" => TRUE));
    }
    public function editSupp($id)
    {
        $data = $this->supplier->get_by_id($id);
        echo json_encode($data);
    }
    public function updateSupp()
    {
        $data = array(
            'KDSUP' => $this->input->post('KDSUP'),
            'NAMA' => $this->input->post('NAMA'),
            'FAKTUR' => $this->input->post('FAKTUR'),
            'FxOrder' => $this->input->post('FxOrder'),
            );
        $this->supplier->update(array('KDSUP' => $this->input->post('KDSUP')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function delSupp($id)
    {
        $this->supplier->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
   
}