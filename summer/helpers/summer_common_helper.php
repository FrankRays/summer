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
		$CI = &get_instance();

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

if( ! function_exists('cur_user')) {
	function cur_user() {
		$CI = &get_instance();

		$user = $CI->session->userdata('user');
		if(empty($user) or ! isset($user['account'])) {
			redirect('c=user&m=login');
		}else{
			return $user;
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
				if($user['admin'] == 'super' or $v['own'] == 'common') {
					$sidebar_str .= '<li><a href="'.site_url($v['href']).'">' . $v['label'] . '</a>';
				}
			}else{
				if($user['admin'] == 'super' or $v['own'] == 'common') {
					$sidebar_str .= '<li><a class="am-cf" data-am-collapse="{target: \'listtarge'.$index.'\'}" >';
					$sidebar_str .= $v['label'];
					$sidebar_str .= '</a>';
					if(isset($v['childern']) && is_array($v['childern'])) {
						$sidebar_str .= '<ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">';
						foreach($v['childern'] as $v2) {
							if($user['admin'] == 'super' or $v['own'] == 'common') {
								$sidebar_str .= '<li><a href="'.site_url($v2['href']).'" class="am-cf">';
								$sidebar_str .= $v2['label'];
								$sidebar_str .= '</a></li>';
							}
						}
						$sidebar_str .= '</ul>';
					}
					$sidebar_str .= '</li>';
				}
			}
		}

		return $sidebar_str;
	}
}


if( ! function_exists('make_upload_dir')) {

	//return : absotute path of upload file on server
	function make_upload_dir() {
		$CI = &get_instance();
		$upload_path = './resource';
		if( ! file_exists($upload_path)) {
			show_error('文件上传本地路径不存在');
		}

		$relative_path = date('Y/m/d/');
		$upload_path = trim($upload_path, '/') . '/' . $relative_path;
		if( ! file_exists($upload_path)) {
			if( ! mkdir($upload_path, 0777, TRUE)) {
				show_error('创建上传图片路径失败');
			}
		}
		return $upload_path;		
	}
}

if( ! function_exists('get_upload_path')) {
    function get_upload_path(){
        return make_upload_dir();
    }
}

if( ! function_exists('get_random_file_name')) {
	function get_random_file_name() {
		return time() . '_' . rand(0, 999);
	}
}


if(! function_exists('back_get_front_site_url')) {

	function back_get_front_site_url($url) {
		$CI = &get_instance();
		$CI->config->set_item('index_page', 'index.php');
		$CI->config->set_item('enable_query_strings', FALSE);
		$CI->config->set_item('url_suffix', '.html');
		$site_url = site_url($url);
		$CI->config->set_item('index_page', 'y.php');
		$CI->config->set_item('enable_query_strings', TRUE);
		$CI->config->set_item('url_suffix', '');
		return $site_url;
	}
}

if( ! function_exists('cms_version')) {
	function cms_version() {
		$CI = &get_instance();
		return $CI->config->item('cms_version');
	}
}

if( ! function_exists('set_ajax_header')) {
    function set_ajax_header() {
        get_instance()->output->set_header('Content-Type:application/json;charset=utf-8');
    }
}
