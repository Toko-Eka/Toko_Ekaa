<?php
class auth_model extends CI_Model
{
	function rowuser()
	{   
	$query = $this->db->get('t_user');
    if($query->num_rows()>0)
    {
      return $query->num_rows();
    }
    else
    {
      return 0;
    }
}
	protected $table = 't_user';

	public function login($username,$password)
	{
		$this->db->where('username', $username);
		if ($user = $this->db->get($this->table)->row()) {
			if (password_verify($password, $user->password)) {
				
				$data = array(
					'username' => $user->username,
					'password' => $user->password,
					'id_user' => $user->id_user,
					'status' => 'login'
				);
				$this->session->set_userdata($data);
				return 'sukses';
			} else {
				return 'password';
			}
		} else {
			return "username";
		}
	}

	public function register($username,$password)
	{
		$data = array(
			'username' => $username,
			'password' => password_hash($password, PASSWORD_DEFAULT)
		);
		$this->db->insert($this->table, $data);
		$data['id_user'] = $this->db->insert_id();
	
		$data['status'] = 'login';
		return $data;
	}
	function tampil_user()
	{
		$result = $this->db->get('t_user');
		return $result;
	}

}

/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */
