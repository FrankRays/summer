<?php


defined('BASEPATH') OR exit('No direct script access allowed');


if( ! function_exists('flash_msg')) {
	function flash_msg() {
		$CI = &get_instance();
		if( ! isset($CI->summer_view_helper)) {
			$CI->load->library('summer_view_message');
		}

		return $CI->summer_view_message->get_flash_msg();
	}
}

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
		$base_static_url .= $url . '?version=' . cms_version();
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


if ( ! function_exists('sub_text_mb')) {
	function sub_text_mb(&$str, $length) {
		if(mb_strlen($str) > $length) {
			return mb_substr($str, 0, $length) . '...';
		}
		return $str;
	}
}


if( ! function_exists('archive_url')) {
	function archive_url($id, $cid=0) {
		$CI = &get_instance();
		$photo_category_id = $CI->config->item('photo_category_id');

		if(is_array($id)) {
			$article = $id;
			if($article["is_redirect"] == 1) {
				return $article["come_from_url"];
			}else{
				if(in_array($article["category_id"], $photo_category_id)) {
					return site_url("photo_archive/" . $article["id"]);
				} else {
					return site_url("archive/" . $article["category_id"] . '-' . $article["id"]);
				}
			}
		}
		if( ! $CI->agent->is_mobile()) {
			return site_url('archive/' . $cid . '-' . $id);
		}else{
			if( ! in_array(intval($cid), $photo_category_id)) {
				return site_url('m/archive/' . $cid . '-' . $id);
			} else {
				return site_url('m/photo_archive/' . $id);
			}
		}
	}
}

if( ! function_exists('datetime_compare')) {
	function datetime_compare($datetime_a, $datetime_b) {
		$timestamp_a = strtotime($datetime_a);
		$timestamp_b = strtotime($datetime_b);
		if($timestamp_a > $timestamp_b) {
			return 1;
		} elseif($timestamp_a < $timestamp_b) {
			return -1;
		} else {
			return 0;
		}
	}
}


if( ! function_exists('html_resource')) {
	function html_resource($type) {
		$CI = &get_instance();
		if(empty($CI->js_builder)) {
			$CI->load->library('js_builder');
		}

		switch ($type) {
			case 'css':
				return $CI->js_builder->display_css();
			case 'head_js':
				return $CI->js_builder->display_head_js();
			case 'foot_js':
				return $CI->js_builder->display_foot_js();
			default:
				return '';
		}
		$CI->js_builder->display_css();
	}
}