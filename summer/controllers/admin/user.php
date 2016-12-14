<?php defined('BASEPATH') || exit('no direct script access allowed');

class user extends Ykj_Controller {

	public function __construct(){
		parent::__construct();

		$this -> load -> model('user_model');
	}
}