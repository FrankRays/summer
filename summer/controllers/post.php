<?php defined('BASEPATH') || exit('no direct script access allowed');


class post extends MY_controller {

	public function __construct() {
		parent::__construct();

        $this -> load -> model('news_category_model');
        $this -> load -> model('file_model');
	}

	public function index() {
		$this->browse();
	}

	public function browse() {

        $data['moduleName']= '文章管理';
        $data['moduleDesc'] = '管理多媒体文章信息';

        $category_id = $this->input->get("category_id", true);
        $_POST["category_id"] = $category_id;



        $get = $this->input->get(null, true);
        $pgCfg = $this->config->item("snowConfig/admin");
        $pgCfg = $pgCfg['paginationConfig'];        
        $page = $this -> article_model -> getPages($get['offset']);
        $data['articles'] = $page['dataList'];
        $data['categories'] = $this -> news_category_model -> getRecList();

        if(isset($get['offset'])) {
        	unset($get['offset']);
        }
        $baseUrl = array();
        foreach ($get as $key => &$value) {
        	$baseUrl[] = $key . '=' . $value;
        }
        $pgCfg['base_url'] = site_url(implode($baseUrl, '&'));
        $pgCfg['total_rows'] = $page['count'];
        $this->pagination->initialize($pgCfg);
        $data['pagination'] = $this->pagination->create_links();


        $this->_loadView('v_01/article/browse_view', $data);
	}


}