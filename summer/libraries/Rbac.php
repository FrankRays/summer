<?php defined('APPPATH') OR exit('forbbiden to access');

class Rbac {

	public $CI;

	public $mvc_urls;

	public $allowed_categories;

	public function __construct() {

		if(is_null($this->CI)) {
			$this->CI = &get_instance();
		}

	}


	public function check($mvc_url, $user_id) {
		$user = $this->CI->db->from(TABLE_USER)->where('id', $user_id)->get()->row_array();
		if(empty($user)) {
			show_error('权限检查用户不存在');
		}

		if($user['admin'] == 'super') {
			return TRUE;
		}

		$_mvc_urls = $this->mvc_urls;
		if(is_array($_mvc_urls) and isset($_mvc_urls[$user['id']][$mvc_url])) {
			return TRUE;
		}

		$permission = $this->CI->db->from(TABLE_MODULE)->where('mvc_url', $mvc_url)->get()->row_array();
		if(empty($permission)) {
			show_error('权限检查权限不存在');
		}


		$query = $this->CI->db->query('SELECT moudle.mvc_url as mvc_url FROM ' . TABLE_MODULE . ' as moudle LEFT JOIN ' . TABLE_ACCESS . ' as access on moudle.id=access.moduleid LEFT JOIN '.TABLE_ROLEUSER.' as roleuser on access.roleid=roleuser.role_id where roleuser.user_id=?', array($user['id']));

		$mvc_urls = array();
		foreach ($query->result() as $row) {
			$mvc_urls[$row->mvc_url] = 1;
		}

		$_mvc_urls[$user['id']] = $mvc_urls;
		$this->mvc_urls = $_mvc_urls;

		if(isset($mvc_urls[$mvc_url])) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function check_article_category($category_id, $user_id) {
		$user = $this->CI->db->from(TABLE_USER)->where('id', $user_id)->get()->row_array();
		if(empty($user)) {
			show_error('文章分类权限检查：用户不存在');
		}

		if($user['admin'] == 'super') {
			return TRUE;
		}

		$_allowed_categories = $this->get_allowed_categories($user['id']);

		if(isset($_allowed_categories[$category_id])) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_allowed_categories($user_id=-1) {
		$_allowed_categories = $this->allowed_categories;
		if(isset($_allowed_categories[$user_id])) {
			return $_allowed_categories[$user_id];
		} 	

		if($user_id === -1) {
			$user = $this->CI->session->userdata('user');
		} else {
			$user = $this->CI->db->from(TABLE_USER)->where('id', $user_id)->get()->row_array();
		}
		if(empty($user)) {
			show_error('用户分类不存在');
		}

		if(is_array($user['article_cate_access'])) {
			$categories_id = $user['article_cate_access'];
		} else {
			$categories_id = json_decode($user['article_cate_access'], TRUE);
		}

		$query = $this->CI->db->from(TABLE_ARTICLE_CAT)->where_in('id', $categories_id)->get();

		$cur_allowed_cateogries = array();
		foreach($query->result() as $row) {
			$cur_allowed_cateogries[$row->id] = $row;
		}

		$_allowed_categories[$user_id] = $cur_allowed_cateogries;
		$this->allowed_categories = $_allowed_categories;
		return $cur_allowed_cateogries;
	}
}