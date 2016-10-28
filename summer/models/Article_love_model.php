<?php

class Article_Love_Model extends CI_Model {

	public $table_name;

	public function __construct() {
		parent::__construct();

		$this->table_name = TABLE_ARTICLE_LOVE;
	}

	//v2 增加赞
	public function increase_artilce_love($article_id, $user_id, $ip_addr) {

		$insert_data = array(
			'article_id'	=> $article_id,
            'user_id'       => $user_id,
			'ip_addr'		=> $ip_addr,
			'create_time'	=> date(TIME_FORMAT),
			);

		$this->db->insert(TABLE_ARTICLE_LOVE, $insert_data);

		$this->db->query('UPDATE `' . TABLE_ARTICLE . '` set `love`=`love`+1 where `id`=' . $article_id);
		return $this->db->insert_id();

	}

}
