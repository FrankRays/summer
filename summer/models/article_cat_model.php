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

		$cats_arr = $this->create_tree_a();
		return $cats_arr;
	}

	//v2， 返回生成属性数组
	public function create_tree_a($fid=0) {
		$cats = $this->db
			->select('id, cat_id, name, path, fid')
			->from($this->table_name)
			->where(array('status'=>YES, 'is_delete'=>NO))
			->get()
			->result_array();

		$new_cats = array();
		foreach($cats as $item) {
			$new_cats[$item['fid']][] = $item;
		}

		$cats_str = '';
		$cats_arr = array();
		$this->_create_tree_a($new_cats, $fid, $cats_str, $cats_arr);
		return $cats_arr;
	}


	public function _create_tree_a($data, $fid=0, &$cats_str='', &$cats_arr, $level=0) {
		if(! empty($data[$fid])) {
			$cats_str .= '<ul>';
			foreach ($data[$fid] as $key => $value) {
				$cats_str .= '<li>';
				$cats_str .= $value['name'];
				$value['name'] = str_repeat('&nbsp;', $level * 2) . '|-' . $value['name'];
				$cats_arr[] = $value;
				$this->_create_tree_a($data, $value['id'], $cats_str, $cats_arr, $level + 2);
				$cats_str .= '</li>';
			}
			$cats_str .= '</ul>';
		}
	}

	private function _get_tree($cats = array()) {
		$result = array();
		$p = array();

		foreach ($cats as $v) {
			$value = array(
				'id'	=> $v['id'],
				'fid'	=> $v['fid'],
				'path'	=> $v['path'],
				'name'	=> $v['name'],
				);
			if($value['fid'] == 0) {
				$i = count($result);
				$result[$i] = $value;
				$p[$value['id']] = &$result[$i];
			}else{
				if( ! isset($p[$value['fid']]['children'])) {
					$i = 0;
				}else{
					$i = count($p[$value['fid']]['children']);
				}
				$p[$value['fid']]['children'][$i] = $value;
				$p[$value['id']] = &$p[$value['fid']]['children'][$i];
			}
		}

		return $result;
	}

	public function _create_tree($data, $fid=0, $level=0) {
		$result = array();
		foreach($data as  $key=>$value) {
			if($value['fid'] == $fid) {
				$v = array(
					'id'	=> $value['id'],
					'fid'	=> $value['fid'],
					'path'	=> $value['path'],
					'name'	=> $value['name'],
					);
				$tmp = $v;
				unset($data[$key]);
				$tmp['children'] = $this->_create_tree($data, $v['id'], $level + 1);
				$tmp['name'] = str_repeat('&nbsp;', $level * 3) . $tmp['name'];
				$result[] = $tmp;
			}
		}

		return $result;
	}


	//v2 根据ID获取儿子
	public function get_children($id) {
		$cat = $this->get_by_id($id);

		if($cat === NULL) {
			return array();
		}

		$cats_arr = $this->db
			->select('id, fid, path, name')
			->from($this->table_name)->like('path', $cat['path'] . '-' . $cat['id'], 'after')
			->get()->result_array();
		// $cats_arr = $this->create_tree_a($cat['fid']);
		return $cats_arr;
	}
}