<?php

defined('APPPATH') || exit('no access');

//v2 站点配置模型
class Site_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//v2 增加站点总体点击
	public function increase_site_hits() {
		$this->db->query('update `' . TABLE_SITE . '` set `hits`=`hits`+1 where `id`=1');
	}

	//v2 过去站点名字
	public function get_site_name($site_id) {
		$site = $this->db->from(TABLE_SITE)->where(array('id'=>$site_id))->get()->row_array();
		if(! empty($site)) {
			return $site['name'];
		}else{
			return '';
		}
	}

	public function get_one_by_id($site_id) {
		$site = $this->db->from(TABLE_SITE)->where(array('id'=>$site_id))->get()->row_array();
		return $site;
	}

}


