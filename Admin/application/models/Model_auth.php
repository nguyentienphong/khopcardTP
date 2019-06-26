<?php 

class Model_auth extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* 
		This function checks if the email exists in the database
	*/
	public function check_email($email) 
	{
		if($email) {
			$sql = 'SELECT * FROM users WHERE email = ?';
			$query = $this->db->query($sql, array($email));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}

		return false;
	}

	/* 
		This function checks if the email and password matches with the database
	*/
	public function login($username, $password) {
		if($username && $password) {
			
			$this->db->select("*");
			$this->db->where('username', $username);
			$this->db->where('isadmin', '1');
			$query = $this->db->get('users');

			if($query->num_rows() == 1) {
				$result = $query->row_array();
				$hash_password = password_verify($password, $result['password']);
				if($password == $result['password']) {
					return $result;	
				}
				else {
					return false;
				}

				
			}
			else {
				return false;
			}
		}
	}
	
	public function get_user_group($user_id){
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_group');
		if($query->num_rows() > 0)
		{
			$query = $query->result();
			return $query[0];
		}
		else
			return false;
	}
}