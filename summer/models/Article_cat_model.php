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

	public function get_one_by_alias($alias) {
		$where = array(
			'status'		=> YES,
			'is_delete'		=> NO,
			'alias'			=> $alias,
			);
		$article_cat = $this->db
				->from(TABLE_ARTICLE_CAT)
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

	public function get_pair() {
		
		$where = array(
			'status'	=> '1',
			'is_delete'	=> '0',
			);

		$cats = $this->db->select('id, name, fid')
					->from(TABLE_ARTICLE_CAT)
					->where($where)
					->get()
					->result_array();

		$fid_cats = array();
		foreach($cats as $v) {
			$fid_cats[$v['fid']][] = $v;
		}

		$tree_cats = array();
		$this->_get_pair_tree($fid_cats, 0, $tree_cats, 0);
		return $tree_cats;
	}

	public function _get_pair_tree($fid_cats, $fid, &$cats, $level) {
		if (! empty($fid_cats[$fid]) ) {
			foreach($fid_cats[$fid] as $k => $v) {
				$name = str_repeat('&nbsp;', $level * 2) . '|-' . $v['name'];
				$cats[] = array(
					'name'	=> $name, 
					'id'	=> $v['id'],
					);
				$this->_get_pair_tree($fid_cats, $v['id'], $cats, $level + 2);
			}
		}
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

			$filter_cats = array();
			$this->load->model('user_model');
			if( ! $this->user_model->_is_super()) {
				$user = $this->user_model->get_cur_user();
				foreach($cats as $cat) {
					if(in_array($cat['id'], $user['article_cate_access'])) {
						$filter_cats[] = $cat;
					}
				}
			}


		$new_cats = array();
		foreach($filter_cats as $item) {
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

	//v2 获取路径
	public function get_nav_path($category_id){
		$cat = $this->db->from(TABLE_ARTICLE_CAT)->where('id', $category_id)->get()->row_array();

		$path = '<a href="' . site_url() . '" >首页</a> > ';
		if(!empty($cat) && isset($cat['path'])) {
			$path_arr = explode('-', $cat['path']);
			if( ! empty($path_arr) && is_array($path_arr)) {
				$this->load->helper('html');
				foreach($path_arr as $k=>$v) {
					if($v != 0) {
						$cur_cat = $this->get_by_id($v);

						$path .= '<a href="';
						if( ! empty($cur_cat['alias'])) {
							$path .= site_url('l/' . $cur_cat['alias']);
						}else{
							$path .= site_url('l/' . $cur_cat['id']);
						}

						$path .= '" >'.$cur_cat['name'].'</a> > ';
					}
				}
			}
			$path .= '<a href="';
			if( ! empty($cat['alias'])) {
				$path .= site_url('l/' . $cat['alias']);
			}else{
				$path .= site_url('l/' . $cat['id']);
			}
			$path .= '" >'.$cat['name'].'</a>';
		}

		return $path;
	}
}