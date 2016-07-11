<?php


defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * summer_view
 */

if(!function_exists('getFlashAlert')) {

	function getFlashAlert() {
		$flashData = get_instance()->session->flashdata();
		$returnStr = '';
		if(isset($flashData[FLASH_STATUS]) && isset($flashData[FLASH_MESSAGE])) {
			$returnStr = '<script>alert("'.$flashData[FLASH_MESSAGE].'")';
			$returnStr .= '</script>';
		}

		return $returnStr;
	}
}

if(!function_exists('setFlashAlert')) {

	function setFlashAlert($status, $message) {
		if(empty($status) || empty($message)) {
			return ;
		}
		// $_SESSION[FLASH_STATUS] = 200;
		// $_SESSION[FLASH_MESSAGE] = $this->lang->line('article_save_success');
		

		//set flash session data
		get_instance()->session->set_flashdata(FLASH_STATUS, $status);
		get_instance()->session->set_flashdata(FLASH_MESSAGE, $message);
	}
}

/**
 * instead of function getFlashAlert
 */
if(!function_exists('get_flash_alert')) {
	function get_flash_alert(){
		return getFlashAlert();
	}
}


/**
 * replace function setFlashAlert
 */
if(!function_exists('set_flash_alert')) {
	function set_flash_alert($status, $message) {
		setFlashAlert($status, $message);
	}
}

//v2 设置flash alert
if( ! function_exists('set_flashalert')) {
	function set_flashalert($message, $status=200) {
		$ci = &get_instance();
		$ci->session->set_flashdata(FLASH_MESSAGE, $message);
		$ci->session->set_flashdata(FLASH_STATUS, $status);
	}
}


//v2 图片静态路径和资源静态路径获取方法
if( ! function_exists('static_url')) {

	//get the static url 
	//http://127.0.0.1:9999/xww/resource/2016/06/ecacfb95c2c15eaaf6e61648d709d6b8_960x640.jpg
	function static_url($url='') {
		$base_static_url = get_instance()->config->item('static_base_path');
		$base_static_url .= $url;
		return $base_static_url;
	}
} 

if( ! function_exists('resource_url')) {

	//get the resource url
	function resource_url($url='') {
		$url = str_replace('http://127.0.0.1:9999/xww/resource/', '', $url);
		$base_static_url = get_instance()->config->item('resource_base_path');
		$base_static_url .= $url;
		return $base_static_url;
	}
}