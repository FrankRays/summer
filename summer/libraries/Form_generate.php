<?php

defined('APPPATH') OR exit('forbbiden to access');

class Form_generate {

	public $form = array();

	public $input_wrap_open = '<div class="am-form-group">';

	public $input_wrap_close = '<div class="am-u-sm-4"></div></div>';

	public $label_open = '<label class="am-u-sm-2 am-form-label">';

	public $label_close = '</label>';

	public $input_open = '<div class="am-u-sm-6">';

	public $input_close = '</div>';

	public $form_config;

	public $multiple_form = FALSE;

	public $fields = array();

	public $CI;

	public function __construct($form_config = array()) {

		$this->CI = &get_instance();

		$this->initialize($form_config);
	}

	public function initialize($config) {

		$default_form_config = array(
			'multiple_form'		=> FALSE,
			'action'			=> '',
			"class"				=> '',
			"id"				=> "",
			"method"			=> "post",
			);
		
		$this->form_config = array();
		foreach($default_form_config as $k=>$v) {
			if(isset($config[$k])) {
				$this->form_config[$k] = $config[$k];
			}else{
				$this->form_config[$k] = $v;
			}
		}

		if(isset($config['fields']) and is_array($config['fields'])) {
			$this->fields = $config['fields'];
		}

		// if(isset($config['fields']) and is_array($config['fields'])) {
		// 	$this->fileds = array();
		// 	foreach($config['fields'] as $field) {

		// 		$name = $field['name'];

		// 		if(isset($field['value'])) {
		// 			$value = $field['value'];
		// 		}else{
		// 			if(isset($field['default_value'])) {
		// 				$value = $field['default_value'];
		// 			}else{
		// 				$value = '';
		// 			}
		// 		}

		// 		$this->fileds[] = array(
		// 			'name'	=> $name,
		// 			'value'	=> $value
		// 			);
		// 	}
		// }

	}

	public function set_value($name, $val) {
		$fields = &$this->fields;
		if(isset($fields[$name])) {
			$fields[$name]['value'] = $val;
		}
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


	public function create_form($config = array()) {
		$form_html = '';

		$hiddeninputs = array();
		foreach($this->fields as $name => $attr) {
			if($attr['form_type'] == 'textinput') {
				$form_html .= $this->_create_textinput($name, $attr);
			} else if( $attr['form_type'] == 'radio') {
				$form_html .= $this->_create_radio($attr);
			} else if($attr['form_type'] == 'select') {
				$form_html .= $this->_create_select($attr);
			} else if($attr['form_type'] == "hiddeninput") {
				$hiddeninputs[$attr['name']] = $attr['value'];
			} else if($attr['form_type'] == 'password') {
				$form_html .= $this->_create_password($name, $attr);
			}
		}

		$form_html .= $this->_wrap_input('保存', form_submit('save', '保存'
			, array('type'=>'submit', 'class'=>"am-btn am-btn-default am-radius")));
		$form_html = $this->_wrap_form($form_html, $hiddeninputs);
		return $form_html;
	}

	public function _create_textinput($field_name,  $attr) {
		$input_html = '';

		if(is_array($attr)) {

			$input_html .= '<input type="text" name="' . $field_name . '" ';

			if(isset($_POST[$field_name])) {
				$input_html .= ' value="' . $_POST[$field_name]. '"';
			}

			$input_html .= ' />';

			if(isset($attr['label'])) {
				$input_html = $this->_wrap_input($attr['label'], $input_html);
			} else {
				return FALSE;
			}
		}

		return $input_html;
	}

	public function _create_password($name, $attr) {
		$input_html = '';
		if(is_array($attr)) {
			$input_html .= '<input type="password" name="' . $name . '" ';

			if(isset($_POST[$name])) {
				$input_html .= ' value="'. $_POST[$name] . '" ';
			}

			$input_html .= " />";

			$input_html = $this->_wrap_input($attr['label'], $input_html);
		}

		return $input_html;
	}


	/*
	"target"	=> array(
		"name"			=> "target",
		"type"			=> "char",
		"form_type"		=> "radio",
		"label"			=> "链接到",
		"selects"			=> array(
			array("label"=>"站内", "val"=>'1', "default_checked"=>TRUE),
			array("label"=>"站外", "val"=>'0',)
			)
		),
	 */
	public function _create_radio($params) {
		$input_html = '';


		if(isset($params['value'])) {
			$value = $params['value'];
		}else{
			$radio_post = $this->CI->input->post($params['name']);
			if($radio_post !== NULL) {
				$value = $radio_post;
			} else {
				if(isset($params['default_value'])) {
					$value = $params['default_value'];
				}
			}
		}


		if(is_array($params) and isset($params['selects'])
			and is_array($params['selects'])) {
			foreach($params['selects'] as $radio) {

				if(isset($value) and $radio['value'] == $value) {
					$checked = TRUE;
				}else{
					$checked = FALSE;
				}

				$attr = array(
					'id'	=> $params['name'] . $radio['value'],
					);
				$input_html .= form_radio($params['name'], $radio['value'], $checked, $attr);
				$input_html .= form_label($radio['label'], $attr['id']);
				$input_html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
			}
		}

		$input_html = $this->_wrap_input($params['label'], $input_html);
		return $input_html;
	}

	public function _create_select($params) {
		$input_html = '';

		if(is_array($params) and isset($params['options'])
			and is_array($params['options'])) {

			$options = array();
			foreach($params['options'] as $v) {
				$options[$v['id']] = $v['name'];
			}

			if(isset($params['selected']) and is_array($params['selected'])) {
				$selected = $params['selected'];
			}else{
				$selected = array();
			}
			$input_html .= form_dropdown($params['name'], $options, $selected);
		}

		$input_html = $this->_wrap_input($params['label'], $input_html);
		return $input_html;
	}

	public function set_select_options($field_name, $options) {
		if(is_array($options) and is_string($field_name)) {
			if(isset($this->fields[$field_name]) and is_array($this->fields[$field_name])
				and $this->fields[$field_name]['form_type'] == 'select') {
				$this->fields[$field_name]['options'] = array();
				foreach($options as $value => $label) {
					$this->fields[$options]['options'][$key] = $options;
				}
			} else {
				return FALSE;
			}
		}
	}

	public function _wrap_input($label, $input_html) {
		return $this->input_wrap_open 
		. $this->label_open 
		. $label 
		. $this->label_close 
		. $this->input_open
		. $input_html
		. $this->input_close 
		. $this->input_wrap_close;
	}

	public function _wrap_form($form_html, $hiddeninputs) {
		$form_config = $this->form_config;

		$action = site_url($this->form_config['action']);
		unset($form_config['action']);
		$form_html = form_open($action, $form_config, $hiddeninputs) . $form_html . '</form>';

		return $form_html;
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