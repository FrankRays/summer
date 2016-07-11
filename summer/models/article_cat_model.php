<?php

defined('BASEPATH') || exit('forbidden to access');

class Article_cat_model extends CI_Model {

	public $table_name = 'summer_article_category';

	public function __construct() {
		parent::__construct();

	}

	//v2 添加文章分类
	public function create($article_cat) {
		$this->db->insert($this->table_name, $article_cat);
		return $this->db->insert_id();
	}

	//v2 根据ID获取文章分类
	public function get_by_id($article_cat_id) {
		$where = array(
			'status'		=> YES,
			'is_delete'		=> NO,
			'id'			=> $article_cat_id,
			);
		$article_cat = $this->db
				->from($this->table_name)
				->where($where)
				->get()
				->row_array();

		return $article_cat;
	}

	//v2 根据CATID 获取文章分类
	public function get_by_cat_id($article_cat_id) {
		$where = array(
			'status'		=> YES,
			'is_delete'		=> NO,
			'cat_id'			=> $article_cat_id,
			);
		$article_cat = $this->db
				->from($this->table_name)
				->where($where)
				->get()
				->row_array();

		return $article_cat;

	}

	//v2 根据ID修改文章分类
	public function update_by_id($article_cat, $article_cat_id) {
		$where = array(
			'status'		=> YES,
			'is_delete'		=> NO,
			'id'			=> $article_cat_id,
			);
		$this->db->where($where)->update($this->table_name, $article_cat);
		return $this->db->affected_rows();
	}

	//v2 根据文章ID批量修改文章分类
	public function update_by_ids($article_cat, $article_cat_ids) {
		$where = array(
			'status'		=> YES,
			'is_delete'		=> NO,
			);
		$this->db->where($where)->where_in('id', $article_cat_ids)->update($this->table_name, $article_cat);
		return $this->db->affected_rows();
	}

	//v2 获取所有分类，分级，树形
	public function get_tree() {
		$where = array(
			'is_delete'	=> NO,
			'status'	=> YES,
			);

		$cats = $this->db
					->from($this->table_name)
					->where($where)
					->get()
					->result_array();
		return $cats;
	}


}