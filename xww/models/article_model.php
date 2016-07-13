<?php

defined('APPPATH') OR exit('forbbiden to access');

class Article_Model extends CI_Model {

	//表名
	public $table_name = 'summer_article';

	public function __construct() {
		parent::__construct();
	}


	//根据分类获取该分类的置顶文章,如果没有分类,默认获取所有分类置顶
	public function get_top($cat_id=NULL, $limit=NULL, $offset=NULL) {

		$where = array(
			'is_delete'		=> NO,
			'is_top'		=> YES,	
			'status'		=> YES
			);

		if($cat_id !== NULL) {
			$where['category_id'] = $cat_id;
		}

		if($limit !== NULL) {
			$this->db->limit($limit);
		}

		if($offset !== NULL) {
			$this->db->offset($offset);
		}

		$articles = $this->db->from($this->table_name)
							->where($where)
							->get()
							->result_array();
		return $articles;
	}


	//v2 根据分类IP获取指定数量的文章数组
	public function get_by_cid($cid, $limit, $offset) {
		$where = array(
			'is_delete'		=> NO,
			'is_top'		=> NO,
			'status'		=> YES,
			'category_id'	=> $cid,
			);


		$articles = $this->db->from($this->table_name)
							->where($where)
							->limit($limit)
							->offset($offset)
							->get()
							->result_array();

		return $articles;
	}

	//根据ID获取文章详细信息
	public function get_by_id($id) {
		$where = array(
			'is_delete'		=> NO,
			'status'		=> YES,
			'id'			=> $id,
			);

		$article = $this->db->from('summer_article')->where($where)->get()->row_array();

		return $article;
	}
}