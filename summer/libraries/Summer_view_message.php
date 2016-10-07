<?php defined('APPPATH') or exit('no access')

class Summer_view_message {

	public $messages;

	public $CI;

	public function __construct() {

		$this->$CI = &get_instance();

		if($this->CI->js_builder)

	}

	public append_message($message) {

		if( ! is_array($this->messages)) {
			$this->messages = array();
		}

		$this->message[] = $this->messages;

		$this->session->mark_as_flash($this->flashdata_key);
	}

	public set_flash_message($message, $status) {
		$flashdata = array(
			'message'	=> $message,
			'status'	=> $status,
			);
		$this->session->set_flashdata('summer_flash_data', $flashdata);
	}

	public function get_flas

}