<?php

defined('APPPATH') or exit('no access');


if( ! function_exists('p_article_show')) {
	function p_article_show($category_id) {
		$CI = &get_instance();

		if($CI->user_model == null) {
			$CI->load->model('user_model');
		}

		return $CI->user_model->has_article_privilege($category_id);
	}
}

if( ! function_exists('p_show')) {
	function p_show($privilege_name) {
		$CI = &get_instance();

		if($CI->user_model == null) {
			$CI->load->model('user_model');
		}

		if($CI->user_model->_is_super()) {
			return TRUE;
		} else {
			$user = $CI->user_model->get_cur_user();
		}
	}
}