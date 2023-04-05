<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function  __construct(){
		parent::__construct();
		if ( ! $this->session->userdata('UserID'))
        { 
            redirect('auth');
        }
      

		$this->load->model('UserModel','user');
	
	}
    public function index(){
        $this->load->helper('url');
        $data['userSes'] = $this->db->get_where('dbo.UserID',['UserID'=>
		$this->session->userdata('UserID')])->row_array();
    
            $this->load->view('temp/v_header',$data);
            $this->load->view('admin/v_user',$data);
            $this->load->view('temp/v_footer',$data);
     } 
    
   
     public function usrList()
     {
         $list = $this->user->get_datatables();
         $data = array();
         $no = $_POST['start'];
         foreach ($list as $usr) {
             $no++;
             $row = array();
             $row[] = $usr->UserID;
             $row[] = $usr->AccessGrp;
             $row[] = $usr->is_active;
       
  
             //add html for action
             $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editUsr('."'".$usr->UserID."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                   <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$usr->UserID."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
  
             $data[] = $row;
         }
  
         $output = array(
                         "draw" => $_POST['draw'],
                         "recordsTotal" => $this->user->count_all(),
                         "recordsFiltered" => $this->user->count_filtered(),
                         "data" => $data,
                 );
         //output to json format
         echo json_encode($output);
     }
     public function addUsr()
    {
        $data = array(
                'UserID' => $this->input->post('UserID'),
                'AccessGrp' => $this->input->post('AccessGrp'),
                'is_active' => $this->input->post('is_active'),
            
              
            );
        $insert = $this->user->save($data);
        echo json_encode(array("status" => TRUE));
    }
    public function editUsr($id)
    {
        $data = $this->user->get_by_id($id);
        echo json_encode($data);
    }
    public function updateUsr()
    {
        $data = array(
            'UserID' => $this->input->post('UserID'),
            'AccessGrp' => $this->input->post('AccessGrp'),
            'is_active' => $this->input->post('is_active'),

            );
        $this->user->update(array('UserID' => $this->input->post('UserID')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function delUsr($id)
    {
        $this->user->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
   
}