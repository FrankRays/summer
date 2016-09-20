<?php

class Article_Love_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	//v2 判断是否已经赞过
	public function is_love($article_id, $ip_addr) {
		$where = array(
			'article_id'	=> $article_id,
			'ip_addr'		=> $ip_addr,
			);

		$love = $this->db->from(TABLE_ARTICLE_LOVE)->where($where)->get()->row_array();
		if(empty($love)) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	//v2 增加赞
	public function increase_artilce_love($article_id, $ip_addr) {

		$insert_data = array(
			'article_id'	=> $article_id,
			'ip_addr'		=> $ip_addr,
			'create_time'	=> date(TIME_FORMAT),
			);

		$this->db->insert(TABLE_ARTICLE_LOVE, $insert_data);

		$this->db->query('UPDATE `' . TABLE_ARTICLE . '` set `love`=`love`+1 where `id`=' . $article_id);
		return $this->db->insert_id();

	}

}