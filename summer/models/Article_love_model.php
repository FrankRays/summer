<?php

class Article_Love_Model extends CI_Model {

	public $table_name;

	public function __construct() {
		parent::__construct();

		$this->table_name = TABLE_ARTICLE_LOVE;
	}

	//v2 判断是否已经赞过
	public function is_love($article_id, $ip_addr) {
		$this->load->library('form_validation');
		$this->form_validation->set_data(array('ip_addr' => $ip_addr));
		$this->form_validation->set_rules('ip_addr', 'IP地址', 'required|valid_ip');

		if( ! $this->form_validation->run()) {
			return FALSE;
		}

		$article = $this->db->from(TABLE_ARTICLE)->where('id', intval($article_id))
							->get()->row_array();
		if(empty($article_id)) {
			return FALSE;
		}

		$where = array(
			'article_id'	=> $article_id,
			'ip_addr'		=> $ip_addr,
			);

		$love = $this->db->from($this->table_name)->where($where)->get()->row_array();
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