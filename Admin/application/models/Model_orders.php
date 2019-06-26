<?php 

class model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	protected $_tblOrder = 'orders';
	
	public function get_all_order($fromDate, $toDate, $search, $limit=null, $start=null){
		$fromdate = $fromDate.' 00:00:00';
		$todate = $toDate.' 23:59:59';
		$this->db->select('*');
		if(!empty($fromDate))
			$this->db->where("created_date >=", $fromdate);
		if(!empty($toDate))
			$this->db->where("created_date <=", $todate);
		
		if(!empty($search))
			$this->db->where($search);
		
		$this->db->order_by('priority', 'DESC');
		$this->db->order_by('created_date', 'DESC');
		
		$this->db->limit($limit, $start);
		
		$query = $this->db->get($this->_tblOrder);
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return false;
	}
	
	public function count_list_order($fromDate, $toDate, $search){
		$fromdate = $fromDate.' 00:00:00';
		$todate = $toDate.' 23:59:59';
		
		$this->db->select('*');
		if(!empty($fromDate))
			$this->db->where("created_date >=", $fromdate);
		if(!empty($toDate))
			$this->db->where("created_date <=", $todate);
		
		if(!empty($search))
			$this->db->where($search);
		$query = $this->db->get($this->_tblOrder);
		return $query->num_rows();
	}
}