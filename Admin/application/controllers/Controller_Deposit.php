<?php 

class Controller_Deposit extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		$this->load->model('model_users');
		$this->load->model('model_balance_history');
		
	}

	public function index(){
		$data = array();
		if ($_POST) {
			$this->form_validation->set_rules('id', 'Partner', 'trim|xss_clean|required');
			$this->form_validation->set_rules('amount', 'Số tiền', 'trim|xss_clean|required');
			$this->form_validation->set_rules('type', 'Loại', 'trim|xss_clean|required');
			$this->form_validation->set_rules('message', 'Ghi chú', 'trim|xss_clean|required');
			if ($this->form_validation->run()) {
				
				$user = $this->model_users->get_all_user($this->input->post('id'), 0);
				
				if($user){
					$user = $user[0];
					$amount = str_replace(',', '', $this->input->post('amount'));
					
					if($this->input->post('type') == '2'){
						if(($user->balance - $amount) < 0){
							$wrongAmount = 1;
						}
					}
					
					if(isset($wrongAmount)){
						$this->session->set_flashdata('error', 'Số dư không đủ để trừ tiền');
						redirect('cong-tien-dai-ly', 'refresh');
					} else {
						$deposit = $this->change_balance_user($user, $amount, $this->input->post('type'), $this->input->post('message'));
						
						if($this->input->post('type') == '1'){
							$type = "Cộng tiền";
						} else {
							$type = "Trừ tiền";
						}
						
						if($deposit){
							$this->session->set_flashdata('success', $type .' thành công <b>' . $this->input->post('amount') .  '</b> cho tài khoản <b>' . $user->username . '</b>');
							redirect('cong-tien-dai-ly', 'refresh');
						} else {
							$this->session->set_flashdata('error', $type .' thất bại.');
							redirect('cong-tien-dai-ly', 'refresh');
						}
					}
				} else {
					$this->session->set_flashdata('error', 'Không tìm thấy User');
					redirect('cong-tien-dai-ly', 'refresh');
				}
				
			} else {
				//print_r( $this->form_validation->error_array() );
				log_message('error', 'form_validation false: ' . print_r($this->form_validation->error_array(), true));
			}
		}
		
		$data['user_list'] = $this->model_users->get_all_user(null, 0);
		$data['page_title'] = 'Cộng Trừ tiền cho đại lý';
		
		$this->render_template('deposit/index', $data);
	}

	public function change_balance_user($user, $amount, $type, $message){
		$admin = $this->session->userdata();
		// insert balance history
		$history_data = array('blh_user_id' => $user->id,
								'blh_username' => $user->username,
								'blh_amount' => $amount,
								'blh_before_bal' => $user->balance,
								'blh_user_sent_id' => $admin['id'],
								'blh_user_sent_name' => $admin['username'],
								'blh_message' => $message,
								'blh_type' => $type,
								);
		if($type == '1'){
			// cong tien
			$history_data['blh_after_bal'] = $user->balance + $amount;
			$history_data['blh_trans_id'] = $this->genarateRequestId('CT_');
		} else {
			// tru tien
			$history_data['blh_after_bal'] = $user->balance - $amount;
			$history_data['blh_trans_id'] = $this->genarateRequestId('TT_');
		}
		$insert_balance_history = $this->model_balance_history->insert_history($history_data);
		$update_balance = $this->model_users->update_balance($user->id, $history_data['blh_after_bal']);
		if($insert_balance_history && $update_balance)
			return true;
		else
			return false;
	}
	
	public function genarateRequestId($prefix = null)
	{
		if($prefix == null)
			$prefix = "RQ_";
		
		$transId = $prefix . date('hms') . uniqid();
		return $transId;
	}
}