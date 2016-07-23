<?php

defined('APPPATH') OR exit('forbbiden to access');

class Form_Generate {

	public $form = array();

	public $input_wrap_open = '<div class="am-form-group">';

	public $input_wrap_close = '<div class="am-u-sm-4"></div></div>';

	public $label_open = '<label class="am-u-sm-2 am-form-label">';

	public $label_close = '</label>';

	public $input_open = '<div class="am-u-sm-6">';

	public $input_close = '</div>';

	public function __construct() {

	}

	public function display($config, $data = array()) {
		$form_str = '';

		foreach($config as $key => $value) {
			switch ($value['form_type']) {
				case 'hidden':
					// $form_str .= $this->_generate_hidden($value);
					// break;
				case 'checkbox' :
					$form_str .= $this->_generate_checkbox($value, $data);
					break;
				default:
					$form_str .= $this->_generate_input($value, $data);
					break;
			}
		}

		return $form_str;
	}

	//表单前缀
	private function _open($data) {
		$label = isset($data['label']) ? $data['label'] : '';
		return $this->input_wrap_open . $this->label_open . $label . $this->label_close . $this->input_open;
	}

	//表单后缀
	private function _close() {
		return $this->input_close . $this->input_wrap_close;
	}

	//隐藏表单
	private function _generate_hidden($data) {
		$input_str = '';
		if(is_array($data) && isset($data['attr']) && is_array($data['attr'])) {
			$input_str .= '<input ';
			foreach($data['attr'] as $key=>$value) {
				$input_str .= $key . '="' . $value . '" ';
			}
			$input_str .= '/>';
		}

		return $input_str;
	}

	//普通表单
	private function _generate_input($config, $data =array()) {
		$input_str = '';
		if(is_array($config)) {
			$is_open = 0;
			if(isset($config['attr']) && isset($config['attr']['type']) && $config['attr']['type'] !== 'hidden') {
				$input_str .= $this->_open($config);
				$is_open = 1;
			}

			if(isset($config['attr']) && is_array($config['attr'])) {
				$input_str .= '<input ';
				foreach($config['attr'] as $key=>$value) {
					if($key == 'value') {
						if(empty($value) && isset($data[$config['attr']['name']])) {
							$input_str .= $key . '="' . $data[$config['attr']['name']] . '" ';
						}
					}
					$input_str .= $key . '="' . $value . '" ';
				}
				$input_str .= '/>';
			}

			if($is_open === 1) {
				$input_str .= $this->_close();
			}

		}

		return $input_str;
	}

	//生成checkbox表单 
	private function _generate_checkbox($data) {
		$input_str = '';
		if(is_array($data)) {
			$input_str .= $this->_open($data);
			if(isset($data['checkbox']) && is_array($data['checkbox'])) {
				foreach($data['checkbox'] as $key1 => $value1) {
					if(is_array($value1)) {
						foreach($value1 as $key2 => $value2) {
							$input_str .= $key2 . '="' . $value2 . '" ';
						}
					}
				}
			}
			$input_str .= $this->_close();
		}

		return $input_str;
	}

}