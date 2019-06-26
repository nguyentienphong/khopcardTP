<?php 

class Model_users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	protected $_tblUser = 'users';
	
	public function get_all_user($user_id = null, $isadmin = null, $search = null, $limit=null, $start=null) 
	{
		$this->db->select("*");
		if($user_id !== null) {
			$this->db->where('id', $user_id);
		}
		
		if($isadmin !== null) {
			$this->db->where('isadmin', $isadmin);
		}
		
		if($search !== null){
			$this->db->where($search);
		}
		
		if($limit!==null && $start!==null)
			$this->db->limit($limit, $start);
		
		$this->db->order_by('id', 'DESC');
		
		$query = $this->db->get($this->_tblUser);
		if($query->num_rows() > 0 )
			return $query->result();
		else
			return false;
	}

	public function change_pass($md5OldPass, $md5NewPass, $userid)
	{
		$sql = "SELECT * FROM users WHERE id = ? and password = ?";
		$query = $this->db->query($sql, array($userid,$md5OldPass));
		$numrow = $query->num_rows();
		if($numrow > 0)
		{
			$sql = "update users set password = ? WHERE id = ?";
			$query = $this->db->query($sql, array($md5NewPass,$userid));
			return 1;
		}
		else{
			return -1;
		}
	}
	
	public function update_balance($user_id, $balance){
		$this->db->where('id', $user_id);
		$this->db->set('balance', $balance);
		$this->db->update($this->_tblUser);
		return true;
	}
	
	public function count_list_user($user_id = null, $isadmin = null, $search = null){
		$this->db->select("*");
		if($user_id !== null) {
			$this->db->where('id', $user_id);
		}
		
		if($isadmin !== null) {
			$this->db->where('isadmin', $isadmin);
		}
		
		if($search !== null){
			$this->db->where($search);
		}
		
		$query = $this->db->get($this->_tblUser);
		if($query->num_rows() > 0 )
			return $query->num_rows();
		else
			return false;
	}
	
	public function insertUser($data){
		$this->db->insert($this->_tblUser, $data);
		return $this->db->insert_id();
	}
	
	public function updateUser($id, $data){
		$this->db->where('id', $id);
		$this->db->update($this->_tblUser, $data);
		return true;
	}

}