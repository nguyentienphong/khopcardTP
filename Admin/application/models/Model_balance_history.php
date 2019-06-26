<?php 

class model_balance_history extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	protected $_tblBalanceHistory = 'balance_history';
	
	public function insert_history($data){
		$this->db->insert($this->_tblBalanceHistory, $data);
		return $this->db->insert_id();
	}


}