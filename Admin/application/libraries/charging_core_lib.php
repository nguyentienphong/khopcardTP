<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Charging_core_lib {

	/**
	 * Constructor
	 */
	public function __construct($params = array())
	{
		$this->_ci = get_instance();
		

	}
	
	/*
	**	$arr_list_order : danh sach don hang cos dang array
	**  return data dang json	
	**	
	*/
	public function add_order($arr_list_order){
		log_message('error', 'charging_core_lib ---> add_order start');
		
		$list_data = array();
		$list_data['key_api'] = ADD_ORDER_API_KEY;
		$list_data['list_order'] = array();
		
		foreach($arr_list_order as $key => $order){
			if(isset($order['id'])){
				$data = array(	'request_id' 			=> $order['id'],
							'user_order' 			=> $order['username'],
							'type_order' 			=> ($order['services_code'] == 'N') ? 1 : 2,
							'type_card_order' 		=> $order['account_type_code'],
							'value_order' 			=> $order['amount'],
							'type_add_card'			=> ($order['join_card'] == 'YES') ? 1 : 0,
							'value_min_add_card'	=> $order['price_min'],
							'notes' 				=> $order['note'],
							'sig'					=> MD5(ADD_ORDER_API_KEY . $order['id'] . $order['username'] . $order['amount'] . ADD_ORDER_API_USER)
						);
				array_push($list_data['list_order'], $data);
			} else {
				log_message('error', 'charging_core_lib ---> add_order order detail null: ' . print_r($order, true));
			}
		}
		
		log_message('error', 'charging_core_lib ---> add_order data request: ' . json_encode($arr_list_order));
		$response = $this->post_curl(ADD_ORDER_API_URL . '/addorder', json_encode($list_data));
		if(!empty($response)){
			//$response = json_decode($response);
			return $response;
		} else {
			log_message('error', 'charging_core_lib ---> add_order response empty');
		}
		log_message('error', 'charging_core_lib ---> add_order stop');
		return false;
	}
	
	/*
	**	$order : thong tin don hang co dnag array
	** return data dang json
	*/
	public function cancel_order($order){
		log_message('error', 'charging_core_lib ---> cancel_order start');
		
		$data = array(	'key_api' 	 => ADD_ORDER_API_KEY,
						'request_id' => $order['id'],
						'sig'		 => MD5(ADD_ORDER_API_KEY . $order['id'] . ADD_ORDER_API_USER)
					);
		
		log_message('error', 'charging_core_lib ---> cancel_order data request: ' . json_encode($data));
		$response = $this->post_curl(ADD_ORDER_API_URL . '/cancelorder', json_encode($data));
		if(!empty($response)){
			//$response = json_decode($response);
			return $response;
		} else {
			log_message('error', 'charging_core_lib ---> cancel_order response empty');
		}
		log_message('error', 'charging_core_lib ---> cancel_order stop');
		return false;
	}
	
	/*
	**	$order : thong tin don hang co dnag array
	** return data dang json
	*/
	public function get_order_info($order){
		log_message('error', 'charging_core_lib ---> get_order_info start');
		
		$data = array(	'key_api' 	 => ADD_ORDER_API_KEY,
						'request_id' => $order['id'],
						'sig'		 => MD5(ADD_ORDER_API_KEY . $order['id'] . ADD_ORDER_API_USER)
					);
		
		log_message('error', 'charging_core_lib ---> get_order_info data request: ' . json_encode($data));
		$response = $this->post_curl(ADD_ORDER_API_URL . '/getorder', json_encode($data));
		if(!empty($response)){
			//$response = json_decode($response);
			return $response;
		} else {
			log_message('error', 'charging_core_lib ---> get_order_info response empty');
		}
		log_message('error', 'charging_core_lib ---> get_order_info stop');
		return false;
	}
	
	
	public function genarateRequestId($prefix = null)
	{
		if($prefix == null)
			$prefix = "RQ_";
		
		$transId = $prefix . date('hms') . uniqid();
		return $transId;
	}

	public function post_curl($url, $data_string)
	{
		try
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);           
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

			$output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close($ch);
			//log_message('error', 'http code: ' . $httpcode);
			//log_message('error', 'output: ' . $output);
			if ($httpcode >= 200 && $httpcode < 300)
				return $output;
			else
			{
				return false;
			}
		} catch(Exception $e ) {
			log_message('error', 'Exceptions post_curl: ' . print_r($e, true));
			return false;
		}
	}
	
	public function get_curl($url, $alter = false)
    {
        log_message('error', 'GET_CURL: '.$url);
		try
		{
			$ch = curl_init($url);
			//curl_setopt($ch, CURLOPT_URL, $url);
			//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			//curl_setopt($ch, CURLOPT_TIMEOUT, 500);
			
			//curl_setopt($ch, CURLOPT_URL, $url);
			//curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, "request=".$data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   

			$output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			log_message('error', 'httpcode: ' . $httpcode);
			curl_close($ch);

			if ($httpcode >= 200 && $httpcode < 300){
				return $output;
			}
			else
			{
				return false;
			}
		} catch(Exception $e ) {
			log_message('error', 'Exceptions curl: ' . print_r($e, true));
			return false;
		}
    }
	
}