<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		
	}

	public function index()
	{
		
		$this->form_validation->set_rules('UserID', 'Name','trim|required');
		$this->form_validation->set_rules('Password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Login';
			$this->load->view('auth/login', $data);
		} else {
			$this->_login();
		}
	}
	private function _login()
	{
		$idUser = $this->input->post('UserID');
		$password = $this->input->post('Password');

		$user = $this->db->get_where('dbo.UserId', ['UserID' => $idUser])->row_array();

		// var_dump($user);
		// die;
		
		if ($user) {
		
				if ($password == $user['Password']) {
					$data = [
						'UserID' => $user['UserID'],
						'MenuGrp' => $user['MenuGrp'],
						
					];
					$this->session->set_userdata($data);
					if ($user['MenuGrp'] == 'SUPER') {
						$this->session->set_flashdata('msg', 'Berhasil Login');
						redirect('master');
					} else {
						$this->session->set_flashdata('msg', 'Berhasil Login');
						redirect('master');
					}
				} else {
					$this->session->set_flashdata('err', 'Password / Email Salah');
					redirect('auth');
				}
			
		} else {
			$this->session->set_flashdata('err', 'User Tidak Bisa Ditemukan');
			redirect('auth');
		}
	}
	function logout()
{
	
	$this->session->set_flashdata('msg', 'Berhasil Log Out');
	redirect('auth');
  $this->session->sess_destroy();

	

}

	public function register()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules(
			'email',
			'Email',
			'required|trim|valid_email|is_unique[t_user.email]',
			[
				'is_unique' => 'This Email has Already Registered'
			]

		);
		$this->form_validation->set_rules(
			'password1',
			'Password',
			'required|trim|min_length[3]|matches[password2]',
			[
				'matches' => 'Password dont Match!',
				'min_length' => 'Password too short'
			]

		);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Register';
			$this->load->view('auth/registrasi', $data);
		} else {
			$data = [
				'username' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'is_active' => 1,
				'hak_akses' => 2,
				'date_created' => ("Y-m-d H:i:s")


			];
			$this->db->insert('t_user', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Akun anda berhasil dibuat!, silahkan Login!</div>');
			redirect('auth');
		}
	}
	
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */