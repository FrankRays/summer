<?php 

defined('APPPATH') || exit('no access');

class Nav_Model extends MY_Model {

	public function __construct() {
		parent::__construct();

		$this->table_name = TABLE_NAV;
	}


	public function save() {
		$nav_form = $this->input->post(null, TRUE);

		$insert_nav = array();
		if(isset($nav_form['target']) and $nav_form['target'] == '1') {
			//inside website
			$article_cid = $this->input->post('article_cid');

			$this->load->model('article_cat_model');
			$article_category = $this->article_cat_model->get_by_id($article_cid);

			if($article_category == NULL) {
				return FALSE;
			}

			if(!empty($article_category['alias'])) {
				$href = back_get_front_site_url('l/' . $article_category['alias']);
			} else {
				$href = back_get_front_site_url('l/' . $article_category['id']);
			}

			$insert_nav['href'] = $href;
			$insert_nav['article_cid'] = $article_category['id'];
			$insert_nav['target'] = '1';
			$insert_nav['label'] = $article_category['name'];
		} else {
			$insert_nav['href'] = $nav_form['href'];
			$insert_nav['label'] = $nav_form['label'];
			$insert_nav['target'] = '0';
		}


		$insert_nav['parentid'] = '0';
		$insert_nav['cid'] = $nav_form['cid'];
		$insert_nav['status'] = $nav_form['status'];

		$id = $this->input->post('id', TRUE);
		if(empty($id)) {
			$this->db->insert(TABLE_NAV, $insert_nav);
			return $this->db->insert_id();
		} elseif(is_numeric($id)) {
			$this->db->where('id', $id)->update(TABLE_NAV, $insert_nav);
			return $this->db->affected_rows();
		}

		return FALSE;
	}

	public function get_list($cat_id, $limit, $offset) {
		$where = array(
			'cid'		=> $cat_id,
			'is_delete'	=> 0,
			'status'	=> 1,
			);

		$navs = $this->db->from(TABLE_NAV)
				->select('id, label, href')
				->where($where)
				->limit($limit, $offset)
				->order_by('list_order asc, id asc')
				->get()
				->result_array();

		return $navs;
	}

	public function get_page() {
		if(is_null($this->pagination)) {
			$this->load->library('pagination');
		}
		$page_config = $this->config->item('page_config');

		$limit = $this->input->get('limit', TRUE);
		if(is_null($limit) and ! is_numeric($limit)) {
			$limit = $page_config['per_page'];
		} else {
			$limit = intval($limit);
		}

		$offset = $this->input->get('offset', TRUE);
		if(is_null($offset) and ! is_numeric($offset)) {
			$offset = 0;
		}else{
			$offset = intval($offset);
		}

		$where = array(
			'is_delete'	=> '0',
			);

		$cid = $this->input->get('cid');
		if( ! is_null($cid) and is_numeric($cid)) {
			$where['cid'] = $cond['id'];
		}

		$data_list = $this->db->from(TABLE_NAV)->where($where)->limit($limit, $offset)->get()->result_array();

		$total_rows = $this->db->select('distinct count(*) as total_rows')->from(TABLE_NAV)->where($where)->get()->row_array();

		$page_config['total_rows'] = $total_rows['total_rows'];
		$page_config['base_url'] = deal_page_base_url();
		$this->pagination->initialize($page_config);
		$page_links = $this->pagination->create_links();

		return array(
			'data_list'		=> $data_list,
			'page_links'	=> $page_links,
			'total_rows'	=> $total_rows['total_rows'],
			);
	}

	public function get_mobile_nav($cat_id, $limit, $offset) {
		$navs = $this->get_list($cat_id, $limit, $offset);

		$i = 0;
		foreach($navs as &$v) {
			if(strpos($v['href'], '/l/')) {
				$v['href'] = str_replace('/l/', '/m/l/', $v['href']);
			}
		}

		$navs = array_merge(array_slice($navs, 0, 3),
		 array(array('label'=>'通知公告', 'href'=>site_url('m/l/collegenews'))),
		 array_slice($navs, 3, count($navs)));

		return $navs;
	}

	public function get_cat_pair() {
		$where = array(
			'status'	=> 'Y',
			'is_delete'	=> 'N',
			);

		$nav_cats = $this->db->select('id, name')->from(TABLE_NAV_CAT)
						->where($where)->get()->result_array();

		return $nav_cats;
	}
}