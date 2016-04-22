<?php defined('BASEPATH') || exit('no direct script access allowed');

class post extends MY_controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('news_category_model');
                $this->load->model('article_model');
		$this->load->model('file_model');
	}

	public function index() {
		$this->browse();
	}

	public function browse() {
		$data['moduleName'] = '文章管理';
		$data['moduleDesc'] = '管理多媒体文章信息';

		$get = $this->input->get(null, true);
		$category_id = isset($get['category_id'])  && is_numeric($get['category_id']) ? $get['category_id'] : 0;
		$offset = isset($get['offset']) ? $get['offset'] : 0;



		$_POST["category_id"] = $category_id;

		$pgCfg = $this->config->item("snowConfig/admin");
		$pgCfg = $pgCfg['paginationConfig'];

                $cond = array();
                if($category_id > 0) {
                        $cond['category_id'] = $category_id;
                }
		$page = $this->article_model->getPages($offset, $pgCfg['per_page'], $cond);
		$data['dataList'] = $page['dataList'];
		$data['categories'] = $this->news_category_model->getRecList();

		if (isset($get['offset'])) {
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


                $category = $this->news_category_model->getById($category_id);
                if(!empty($category)) {
                        $data['moduleDesc'] = '['.$category['name'] .'] 管理';

                        if(isset($category['type'])) {
                                if($category['type'] == 'image') {
                                        $this->_loadView('v_01/article/photo_browse_view', $data);
                                }else if($category['type'] == 'video') {
                                        $this->_loadView('v_01/article/video_browse_view', $data);
                                }else if($category['type'] == 'article') {
                                        $this->_loadView('v_01/article/browse_view', $data);
                                }else{
                                        $this->_loadView('v_01/article/browse_view', $data);
                                }
                        }
                }else{

                        $this->_loadView('v_01/article/browse_view', $data);
                }
	}

        public function save() {

                $data['moduleName'] = '增加文章';
                $data['moduleDesc'] = '增加文章';

                $category_id = null;
                if(!empty($_POST)) {
                        //action
                        $post = $this->input->post(null, true);
                        var_dump($post);
                }else{
                        //page
                        $news_id = $this->input->get('news_id');
                        if(!empty($news_id)) {
                                //update page
                                $article = $this->article_model->getById($news_id);
                                $category_id = $article['category_id'];
                                $data['article'] = $article;
                        }else{
                                //create page
                                $category_id = $this->input->get('category_id');
                        }
                }

                if(!empty($category_id)) {
                        $category = $this->news_category_model->getById($category_id);
                        if(!empty($category)) {
                                $_POST['category_id'] = $category['id'];
                        }
                }

                if(isset($category) && !empty($category) && isset($category['type'])) {
                        $data['categories'] = $this->news_category_model->findByCond(array('type'=>$category['type']));

                        if($category['type'] == 'article') {
                                $this->_loadView('v_01/article/create_view', $data);
                        }else if($category['type'] == 'image') {
                                $this->_loadView('v_01/article/photo_create_view', $data);
                        }else if($category['type'] == 'video') {
                                $this->_loadView('v_01/article/video_create_view', $data);
                        }else{
                                $tihs->_loadView('v_01/article/create_view', $data);
                        }


                }else{
                        $data['categories'] = $this->news_category_model->findByCond(array('type', 'article'));
                        $this->_loadView('v_01/article/create_view', $data);
                }

        }

}