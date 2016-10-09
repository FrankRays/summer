<?php defined('APPPATH') or exit('no access')

class Summer_view_message {

	public $messages;

	public $message;

	public $response_data;

	public $CI;

	public $status;

	public function __construct() {

		$this->$CI = &get_instance();

		if($this->CI->js_builder == null) {
			$this->CI->load->library('js_builder');
		}

		$this->js_builder->append_module_resource('layer');
	}

	public function append_message($message) {

		if( ! is_array($this->messages)) {
			$this->messages = array();
		}

		$this->message[] = $this->messages;

		$this->session->mark_as_flash($this->flashdata_key);
	}

	public function set_error($message) {
		$this->message = $message;
		$this->status = 'error';
	}

	public function set_message($message, $status) {
		$this->message = $this->message;
		$this->status = $status;
	}

	public function set_flash_message($message, $status) {
		$flashdata = array(
			'message'	=> $message,
			'status'	=> $status,
			);
		$this->session->set_flashdata('summer_flash_data', $flashdata);
	}

	public function get_flash_message() {
		
	}

	public function set_response_data($response_data) {
		$this->response_data = $response_data;
	}

	public function json_message() {
		if(empty($this->message)) {
			$message = '';
		} else {
			$message = $this->message;
		}

		if(empty($this->status)) {
			$status = 'normal';
		} else {
			$status = $this->status;
		}

		$response = array(
			'message'	=> $message,
			'status'	=> $status,
			);
		if( ! empty($this->response_data)) {
			$response['response_data'] = $this->response_data;
		}

		return json_encode($response);
	}

}