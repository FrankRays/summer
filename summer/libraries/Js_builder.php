<?php 

defined("APPPATH") or exit("no access");

class Js_Builder {

	public $js = array();

	public $js_source_code;

	public function __construct() {

	}

	public function js_include_display() {

	}


	public function js_source_code_display() {
		return '<script type="text/javascript">' . $this->js_source_code
		. '</script>';
	}

	public function append_source_code($source_code) {
		if(empty($this->js_source_code)) {
			$this->js_source_code = $source_code;
		} else {
			$this->js_source_code .= $source_code;
		}
	}

	public function get_js_source_code() {
		return '<script type="text/javascript">' . $this->js_source_code
		. '</script>';
	}

}