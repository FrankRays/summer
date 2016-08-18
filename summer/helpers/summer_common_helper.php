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
				$module_path_str .= '<a href="' . $v[1] . '" >' . $v[0] . '</a> > ';
			}
		}
		return $module_path_str;
	}
}


//处理分页base_url
if( ! function_exists('deal_page_base_url')) {
	function deal_page_base_url() {
		$CI = &get_instance();
		$base_url_arr = array();
		foreach($CI->input->get() as $k=>$v) {
			if($k != 'offset') {
				$base_url_arr[] = $k . '=' . $v;
			}
		}

		return site_url(implode($base_url_arr, '&'));
	}
}


//get the sidebar
if( ! function_exists('get_sidebar')) {
	function get_sidebar() {
		$CI = &get_instance();
		$sidebar_config = $CI->config->item('sidebar_config');
		$user = $CI->session->userdata('user');

		$sidebar_str = '';
		$index = 0;
		foreach($sidebar_config as $v) {
			if( ! isset($v['childern'])) {
				$sidebar_str .= '<li><a href="'.site_url($v['href']).'">' . $v['label'] . '</a>';
			}else{
				$sidebar_str .= '<li><a class="am-cf" data-am-collapse="{target: \'listtarge'.$index.'\'}" >';
				$sidebar_str .= $v['label'];
				$sidebar_str .= '</a>';
				if(isset($v['childern']) && is_array($v['childern'])) {
					$sidebar_str .= '<ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">';
					foreach($v['childern'] as $v2) {
						$sidebar_str .= '<li><a href="'.site_url($v2['href']).'" class="am-cf">';
						$sidebar_str .= $v2['label'];
						$sidebar_str .= '</a></li>';
					}
					$sidebar_str .= '</ul>';
				}
				$sidebar_str .= '</li>';
			}
		}

		return $sidebar_str;
	}
}
