<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Change_Pass extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Change password';

		$this->load->model('model_users');
	}


	public function index()
	{
		if($_POST){
			$this->form_validation->set_rules('oldpassword', 'Password', 'trim|xss_clean|required');
			$this->form_validation->set_rules('newpassword', 'Password', 'trim|xss_clean|required');
			$this->form_validation->set_rules('confnewpassword', 'Password', 'trim|xss_clean|required');

			$userid = $this->session->userdata('id');
			if ($this->form_validation->run() == TRUE) {
				if (isset($_POST['submit'])) {
					$oldpass = $_POST['oldpassword'];
					$newpass = $_POST['newpassword'];
					$confnewpass = $_POST['confnewpassword'];

					if($newpass != $confnewpass)
					{
						//Password moi nhap khong dung
						$this->session->set_flashdata('error', 'Mật khẩu nhập lại không đúng');
						//$this->load->view('change_pass', $this->data);
					}else{
						$changePassRs = $this->model_users->change_pass(md5(md5($oldpass)), md5(md5($newpass)), $userid);
						if($changePassRs > 0)
						{	
							$this->session->set_flashdata('success', 'Thay đổi mật khẩu thành công');
							//$this->load->view('change_pass', $this->data);
						}else if($changePassRs = -1){
							$this->session->set_flashdata('error', 'Mật khẩu cũ không đúng');
							//$this->load->view('change_pass', $this->data);
						}
						else{
							$this->session->set_flashdata('error', 'Thay đổi mật khẩu thất bại');
							//$this->load->view('change_pass', $this->data);
						}
					}
				}
				// true case
			}
		}
		
		$this->render_template('change_pass/index', $this->data);
	}

}