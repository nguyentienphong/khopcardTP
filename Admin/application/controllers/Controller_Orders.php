<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Orders extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		$this->load->library('pagination');
		$this->load->model('model_orders');
		
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		$data = array();
		//$fromDate = date("Y-m-d", time());
		$fromDate = date("Y-m-d", strtotime(date("Y-m-d", time()) . ' -2 day' ));
		$toDate = date("Y-m-d", time());
		$where = array();
		$listOrder = "";
		$total_records = "";
		$limit_per_page = 10;
		$start_index =  (int)($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		if($start_index > 0){
			$start_index = ($start_index -1)*$limit_per_page;
		}
		$where['status'] = '99';
		
		if ($_GET) {
			
			$this->form_validation->set_data($this->input->get());
			
			$this->form_validation->set_rules('fromDate', 'fromDate', 'trim|xss_clean');
			$this->form_validation->set_rules('toDate', 'toDate', 'trim|xss_clean');
			$this->form_validation->set_rules('slFinalStatus', 'Status', 'trim|xss_clean');
			if ($this->form_validation->run()) {
				
				if($this->input->get('fromDate') != null && $this->input->get('fromDate') != '')
					$fromDate = date("Y-m-d", strtotime($this->input->get('fromDate')));
				
				if($this->input->get('toDate') != null && $this->input->get('toDate') != '')
					$toDate = date("Y-m-d", strtotime($this->input->get('toDate')));
				
				if($this->input->get('slFinalStatus') != '')
					$where['status'] = $this->input->get('slFinalStatus');
				else
					unset($where['status']);
			}
		}
		
		$listOrder = $this->model_orders->get_all_order($fromDate, $toDate, $where, $limit_per_page, $start_index);
		$total_records = $this->model_orders->count_list_order($fromDate, $toDate, $where);
		
			if(isset($_GET['export'])){
				if($listOrder){
					$this->load->file('phpExcel/Classes/PHPExcel.php');
					$this->load->file('phpExcel/Classes/PHPExcel/IOFactory.php');
					
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$objExcel = $objReader->load(FCPATH . "templates/DonHangMau.xlsx");
					
					set_time_limit(0);
					$objExcel->setActiveSheetIndex(0);
					$i = 2;
					foreach ($listOrder as $key => $row) {
						$objExcel->getActiveSheet()
							->setCellValue('A' . $i, ($key+1))
							->setCellValue('B' . $i, $row['username'])
							->setCellValue('C' . $i, $row['amount'])
							->setCellValue('D' . $i, $row['services_code'])
							->setCellValue('E' . $i, $row['account_type_code'])
							->setCellValue('F' . $i, $row['join_card'])
							->setCellValue('G' . $i, $row['price_min'])
							->setCellValue('H' . $i, $row['note'])
							;
						$objExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(-1);
						
						$i++;
						$objExcel->getActiveSheet()->insertNewRowBefore($i, 1);
					}
					ob_end_clean();
					$filename = 'Don_Hang_' . date('d_m_Y_H_i_s') . '.xlsx';
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' . $filename . '"');
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
					$objWriter->save('php://output');
					exit();
				}
				
			}
		
		
		$this->config->load('pagination', TRUE);
		$config = $this->config->item('pagination', 'pagination');
		$config['base_url'] = base_url() . 'quan-ly-don-hang/danh-sach-don-hang';
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit_per_page;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();
		
		$data['results'] = $listOrder;
		$data['total_records'] = $total_records;
		$data['page_title'] = 'Quản lý đơn hàng';
		$this->render_template('orders/index', $data);		
	}

}