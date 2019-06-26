<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_User extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		$this->load->library('pagination');
		
		$this->load->model('model_users');
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		$data = array();
		$where = array();
		$listOrder = "";
		$total_records = "";
		$limit_per_page = 10;
		$start_index =  (int)($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		if($start_index > 0){
			$start_index = ($start_index -1)*$limit_per_page;
		}

		if ($_GET) {
			
			$this->form_validation->set_data($this->input->get());
			
			$this->form_validation->set_rules('username', 'Tên tài khoản', 'trim|xss_clean');
			if ($this->form_validation->run()) {
				
				if($this->input->get('username') != '')
					$where['username'] = $this->input->get('username');
				
			}
		}
		
		$list_records = $this->model_users->get_all_user(null, '0', $where, $limit_per_page, $start_index) ;
		$total_records = $this->model_users->count_list_user(null, '0');
		
		$this->config->load('pagination', TRUE);
		$config = $this->config->item('pagination', 'pagination');
		$config['base_url'] = base_url() . 'quan-ly-tai-khoan-dai-ly/danh-sach';
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit_per_page;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();
		
		$data['results'] = $list_records;
		$data['total_records'] = $total_records;
		$data['page_title'] = 'Quản lý tài khoản đại lý';
		$this->render_template('user/index', $data);		
	}
	
	public function edit(){
		$id = $this->uri->segment(3);
		$data = array();
		$data['user_info'] = $this->model_users->get_all_user($id, 0);
		if ($_POST) {
			
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'numeric|max_length[10]|trim|xss_clean|required');
			$this->form_validation->set_rules('fullname', 'Họ và tên', 'max_length[100]|trim|xss_clean|required');
			$this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[100]|trim|xss_clean|required');
			if ($this->form_validation->run()) {
				$data_insert = array('email' => $this->input->post('email'),
									'fullname' => $this->input->post('fullname'),
									'phone' => $this->input->post('phone'));
				if($this->model_users->updateUser($id, $data_insert)){
					$this->session->set_flashdata('success', 'Cập nhật tài khoản thành công');
					redirect('quan-ly-tai-khoan-dai-ly', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Cập nhật tài khoản thất bại');
					redirect('quan-ly-tai-khoan-dai-ly', 'refresh');
				}
			}
		}
		
		if($data['user_info']){
			$data['page_title'] = 'Thêm mới tài khoản đại lý';
			$data['user_info'] = $data['user_info'][0];
			$this->render_template('user/edit', $data);
		} 
	}
	
	public function create(){
		$data = array();
		
		if ($_POST) {
			$this->form_validation->set_rules('username', 'Tên tài khoản', 'min_length[6]|max_length[100]|trim|xss_clean|required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'numeric|max_length[10]|trim|xss_clean|required');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|xss_clean|required');
			$this->form_validation->set_rules('fullname', 'Họ và tên', 'max_length[100]|trim|xss_clean|required');
			$this->form_validation->set_rules('cpassword', 'Mật khẩu nhập lại', 'trim|xss_clean|required|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[100]|trim|xss_clean|required');
			if ($this->form_validation->run()) {
				$data_insert = array('username' => $this->input->post('username'),
									'password' => $this->input->post('password'),
									'email' => $this->input->post('email'),
									'fullname' => $this->input->post('fullname'),
									'phone' => $this->input->post('phone'),
									'isadmin' => '0',
									'active' => '1',
									'balance' => '0'
									//'password_lv2' => $this->input->post('password_lv2'),
									);
				if($this->model_users->insertUser($data_insert)){
					$this->session->set_flashdata('success', 'Tạo tài khoản thành công');
					redirect('quan-ly-tai-khoan-dai-ly', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Tạo tài khoản thất bại');
					redirect('quan-ly-tai-khoan-dai-ly', 'refresh');
				}
			}
		}
		
		$data['page_title'] = 'Thêm mới tài khoản đại lý';
		$this->render_template('user/create', $data);
	}
	
	public function lock_unlock(){
		
		if ($_POST) {
			$this->form_validation->set_rules('user_id', 'Tên tài khoản', 'trim|xss_clean|required');
			$this->form_validation->set_rules('user_status', 'Tên tài khoản', 'trim|xss_clean|required');
			if ($this->form_validation->run()) {
				$data['user_info'] = $this->model_users->get_all_user($this->input->post('user_id'), 0);
				if($data['user_info']){
					$user_info = $data['user_info'][0];
					if($this->input->post('user_status') == $user_info->active){
						if($this->input->post('user_status') == '1'){
							$tyle = "Khóa";
							$data_update = array('active' => '2');
						} else {
							$tyle = "Mở khóa";
							$data_update = array('active' => '1');
						}
						$this->model_users->updateUser($this->input->post('user_id'), $data_update);
						$this->session->set_flashdata('success', $tyle . ' thành công');
						redirect('quan-ly-tai-khoan-dai-ly', 'refresh');
					} else {
						$this->session->set_flashdata('success', 'Thành công');
						redirect('quan-ly-tai-khoan-dai-ly', 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Không tìm thấy tài khoản');
					redirect('quan-ly-tai-khoan-dai-ly', 'refresh');
				}
			}
		}
		
	}

}