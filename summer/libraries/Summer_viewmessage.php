<?php

defined('APPPATH') or exit('no access');


class Summer_viewmessage {

	public $CI;

	public $session_key_status = 'save_status';

	public $session_key_message = 'save_message';

	public function __construct() {

		if($this->CI == null) {
			$CI = &get_instance();
		}

		if($this->CI->session == null) {
			$this->CI->load->library('session');
		}

	}

	public function set_alert_and_redirect($alert, $redirect_url) {
		$this->CI->session->set_falshdata()
	}
}