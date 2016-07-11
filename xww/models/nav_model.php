<?php

defined('BASEPATH') || exit('no direct access script allowed');

class Nav_model extends CI_Model {

	public $table = 'nav';

	public function __construct() {
		parent::__construct();

		$this->table = $this->config->item('table_prefix').$this->table;
		$this->table_name = $this->table;
	}

	public function get_front_navs($cid=1) {

		$this->db->select(
			array('id', 'cid', 'parentid', 'label', 'target', 'href', 'icon', 'status',
			'list_order', 'path', 'is_delete')
			);

		$this->db->from($this->table);

		$where = array(
			'cid' 		=> $cid,
			'is_delete' => 0,
			);
		$this->db->where($where);
		$this->db->order_by('list_order asc, id asc');

		$query = $this->db->get();
		$navs = $query->result_array();

		if(empty($navs)) {
			return array();
		}else{
			return $navs;
		}
	}

	public function create($nav) {
		$this->db->insert($this->table, $nav);
		$last_insert_id = $this->db->insert_id();
		if(!empty($last_insert_id)) {
			return $last_insert_id;
		}else{
			return false;
		}
	}

	public function create_test() {
		$nav = array(
			'cid'		=> 1,
			'label'		=> '学院首页',
			'href'		=> 'http://www.svtcc.edu.cn',
			'status'	=> 1,
			'is_delete'	=> 0,
			);
		$nav_arr = array(
			array('label'=>'首页', 		'href'=>site_url()),
			array('label'=>'学院新闻',	'href'=>site_url('collegenews')),
			array('label'=>'系部动态',	'href'=>site_url('departmentnotice')),
			array('label'=>'图片新闻',	'href'=>site_url('photonews')),
			array('label'=>'聚焦热点',	'href'=>site_url('focushot')),
			array('label'=>'视频展播',	'href'=>site_url('videodispay')),
			array('label'=>'媒体交院',	'href'=>site_url('svtccmedia')),
			array('label'=>'光影交院',	'href'=>site_url('svtccphoto')),
			array('label'=>'耕读交院',	'href'=>site_url('svtccreading')),
			);

		foreach ($nav_arr as $key => $value) {
			$nav['label'] = $value['label'];
			$nav['href'] = $value['href'];

			$this->create($nav);
		}
	}
}