<?php 

defined("APPPATH") or exit("no access");

class Js_Builder {

	public $js = array();

	public $css_hrefs = array();

	public $js_head_hrefs = array();

	public $js_foot_hrefs = array();

	public $js_source_code;

	public $CI;

	public $resource;

	public function __construct() {
		if( $this->CI === null) {
			$this->CI = &get_instance();
		}

		$this->CI->config->load('resource');
		$this->resource = $this->CI->config->item('resource');

		$this->init();
	}

	public function init($modules=array()) {
		if(is_array($modules)) {
			foreach($modules as $module) {
			}
		}
	}

	public function append_module_resource($module_name) {
		if( ! isset($this->resource[$module_name])) {
			return FALSE;
		} else {
			$module = $this->resource[$module_name];
		}

		$js = isset($module['js']) ? $module['js'] : array();
		$css = isset($module['css']) ? $module['css'] : array();

		foreach($js as $js_href) {
			if(strpos($js_href, 'http') === FALSE) {
				$js_href = static_url($js_href);
			} 

			$this->js_head_hrefs[] = $js_href;
		}

		foreach($css as $css_href) {
			if(strpos($css_href, 'http') === FALSE) {
				$css_href = static_url($css_href);
			}

			$this->css_hrefs[] = $css_href;
		}
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