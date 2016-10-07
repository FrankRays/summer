<?php defined('APPPATH') or exit('no access');

class Summer_panel {

	public $module_name;

	public $module_desc;

	public $module_bread_path;

	public $message;

	public $message_status = array('success', 'warning', 'danger', 'normal', 'secondary');

	public $flashdata_key = 'summer_flash_data';

	public function __construct() {

	}


	public set_flash_data($message, $status) {

	}


}