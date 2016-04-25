<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Summer_base_controller extends CI_Controller {


	public function __construct(){
		parent::__construct();

		if(method_exists($this, "_init")) {
			$this->_init();
		}
	}
}