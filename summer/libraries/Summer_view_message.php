<?php defined('APPPATH') or exit('no access');

class Summer_view_message {

	public $messages;

	public $message;

	public $response_data;

	public $CI;

	public $status;

	public static $valid_status = array('success', 'warning', 'danger', 'secondary');

	public static $flashdata_key;

	public function __construct() {

		$this->CI = &get_instance();

		if( ! isset($this->CI->js_builder)) {
			$this->CI->load->library('js_builder');
		}
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
		$this->CI->session->set_flashdata('summer_flash_data', $flashdata);
	}

	public function set_flash_msg($msg, $status) {
		$this->CI->session->mark_as_flash('flash_msg');

		$falsh_msg = array(
			'msg'		=> $msg,
			'status'	=> $status,
			);
		$this->CI->session->set_flashdata('flash_msg', $falsh_msg);
	}

	public function get_flash_msg() {
		$flash_msg = $this->CI->session->userdata('flash_msg');

		$msg_html = '';
		if( ! empty($flash_msg)) {
			$msg = isset($flash_msg['msg']) ? $flash_msg['msg'] : '';
			$alert_type_class = '';
			if(isset($flash_msg['status'])) {
				if(in_array($flash_msg['status'], array('success', 'warning', 'danger', 'secondary'))) {
					$alert_type_class = 'am-alert-'.$flash_msg['status'];
				} 		
			}
			$msg_html = '<div class="am-alert '.$alert_type_class.'" data-am-alert>
				  <button type="button" class="am-close">&times;</button>';

			if(is_array($msg)) {
				foreach($msg as $item) {
					$msg_html .= '<p>'.$item.'</p>';
				}
			} else {
				$msg_html .= '<p>'.$msg.'</p>';
			}

			$msg_html .= '</div>';
		}

		return $msg_html;
	}

	public function set_response_data($response_data) {
		$this->response_data = $response_data;
	}

	public function ajax_msg($msg, $status) {
		$this->CI->output->set_header('Content-Type: application/json');
		$response = array(
			'msg'		=> $msg,
			'status'	=> $status,
			);

		return json_encode($response);
	}
}