<?php 

defined("APPPATH") or exit("no access");

class Js_Builder {

	public $js = array();

	public $css_hrefs = array();

	public $js_head_hrefs = array();

	public $js_foot_hrefs = array();

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

	public function append_css($css_href) {
		if( ! is_array($this->css_hrefs)) {
			$this->css_hrefs = array();
		}

		array_push($this->css_hrefs, $css_href);
	}

	public function display_css() {
		$css_html = '';
		if( ! is_array($this->css_hrefs)) {
			return '';
		}

		foreach($this->css_hrefs as $href) {
			$css_html .= '<link rel="stylesheet" type="text/css" href="'.$href.'">';
		}

		return $css_html;
	}

	public function append_head_js($js_href) {
		array_push($this->js_head_hrefs, $js_href);
	}

	public function append_foot_js($js_href) {
		array_push($this->js_foot_hrefs, $js_href);
	}

	public function display_head_js() {
		if( ! is_array($this->js_head_hrefs)) {
			return '';
		}

		$js_head_hrefs_html = '';
		foreach ($this->js_head_hrefs as $href) {
			$js_head_hrefs_html .= '<script type="text/javascript" src="'.$href.'"></script>';
		}
		return $js_head_hrefs_html;
	}

	public function display_foot_js() {
		if( ! is_array($this->js_foot_hrefs)) {
			return '';
		}

		$js_foot_hrefs_html = '';
		foreach($this->js_foot_hrefs as $href) {
			$js_foot_hrefs_html .= '<script type="text/javascript" src="'.$href.'"></script>';
		}

		return $js_foot_hrefs_html;
	}

}