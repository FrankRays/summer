<?php

defined('BASEPATH') || exit('no direct access script allowed');

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
		$url = str_replace('resource/', '', $url);
		$base_static_url = get_instance()->config->item('resource_base_path');
		$base_static_url .= $url;
		return $base_static_url;
	}
}