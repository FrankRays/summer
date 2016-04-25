<?php

require_once(SUMMER_PATH . 'controllers/module');

class News extends Module {


	public function __construct() {
		parent::__construct();
		
	}

	public function index() {
		echo "Hello index";
	}
}