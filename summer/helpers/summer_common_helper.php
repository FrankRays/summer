<?php

defined('BASEPATH') || exit('no direct access script allowed');


//得到当前用户ID
if( ! function_exists('cur_user_id')) {
	function cur_user_id() {
		$CI = get_instance();

		$user = $CI->session->userdata('user');
		if(empty($user)) {
			return FALSE;
		}

		if(isset($user['id'])) {
			return $user['id'];
		}else{
			return FALSE;
		}
	}
}


//得到当前用户
if( ! function_exists('cur_user_account')) {

	function cur_user_account() {
		$CI = get_instance();

		$user = $CI->session->userdata('user');
		if(empty($user)) {
			return FALSE;
		}

		if(isset($user['account'])) {
			return $user['account'];
		}else{
			return FALSE;
		}

	}
}


//获取栏目面包屑导航

if(!function_exists('get_module_path')) {
	function get_module_path($module_array = array()) {
		$module_path_str = '';
		if(is_array($module_array)) {
			foreach($module_array as $v) {
				$module_path_str .= '<a href="' . $v[1] . '" >' . $v[0] . '</a> / ';
			}
		}
		return $module_path_str;
	}

}