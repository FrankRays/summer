<?php

defined('APPPATH') OR exit('forbidden to access');

/**
 * function of get data from module to use for view
 */


//获取指定数量的文章数组
function darticle($cond = array()) {
	$CI = &get_instance();

	$where = array(
		'status'	=> YES,
		'is_delete'	=> NO,
		);
	if(isset($cond['category_id'])) {
		$where['category_id'] = $cond['category_id'];
	}

	if(isset($cond['limit'])) {
		$CI->db->limit($cond['limit']);
	}

	if(isset($cond['offset'])) {
		$CI->db->offset($cond['offset']);
	}

	if(isset($cond['is_top'])) {
		$where['is_top'] = $cond['is_top'];
	}

	$select = array('id', 'title', 'category_id', 'category_name', 'publish_date', 'summary',
		'coverimg_path');
	
	$article = $CI->db
			->select($select)
			->from('summer_article')
			->where($where)
			->get()->result_array();
	foreach($article as &$v) {
		$v['href'] = site_url('archive/'.$v['id']);
		$v['coverimg_path'] = static_url($v['coverimg_path']);
	}

	return $article;
}


//根据ID获取具体文章内容
function darticle_detail() {
	$CI = &get_instance();

	$article_id = $this->uri->segment(2);
	if($article_id === NULL || ! is_numeric($article_id)) {
		show_error('GET 参数中没有ID值或不正确');
	}

	$article_id = intval($article_id);
	$where = array(
		'is_delete'		=> NO,
		'status'		=> YES,
		'id'			=> $article_id,
		);
	$article = $CI->db->from('summer_article')->where($where)->limit(1)->get()->row_array();
	if(empty($article)) {
		show_404('文章不存在');
	}

	return $article;
}

//更具nav分类获取nav列表
function dnav($cond) {
	$CI = &get_instance();
	if( ! $cond['cid']) {
		exit('查询导航分类不能为空');
	}

	$where['cid'] = intval($cond['cid']);

	$navs = $CI->db->from('summer_nav')->where($where)->get()->result_array();
	var_dump($navs);

}