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
                        $post = $this->input->post();
                        if(isset($post['id']) && !empty($post['id'])) {
                                //update
                                $article = $this->_getUpdateArticle($post);
                                $this->article_model->updateArticle($article, array('id'=>intval($post['id'])));

                        }else{
                                //create
                                $article = $this->_getCreateArticle($post);
                                // var_dump($article);
                                $this->article_model->createArticle($article);
                        }
                        redirect(site_url('c=post&category_id='.$article['category_id']));
                }else{
                        //page
                        $news_id = $this->input->get('news_id');
                        if(!empty($news_id)) {
                                //update page
                                $article = $this->article_model->getById($news_id);
                                $category_id = $article['category_id'];
                                $data['article'] = $article;
                                $data['content'] = array('article' => $article);
                                $article['add_time'] = date('Y-m-d H:i:s', $article['add_time']);
                                $_POST = array_merge($_POST, $article);
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

        public function setTop() {
                $id = $this->input->get('id', true);
                if(!empty($id)) {
                        $this->article_model->setTop(intval($id));
                        $article = $this->article_model->getById(intval($id));
                        if(!empty($article) && isset($article['category_id'])) {
                                redirect(site_url('c=post&category_id='.$article['category_id']));
                                $_POST['category_id'] = $article['category_id'];
                        }
                }
                redirect(site_url('c=post'));
        }

        public function del() {
                $id = $this->input->get('id');
                $article = $this->article_model->getById(intval($id));
                if(!empty($article)) {
                        $this->article_model->delOneById($article['id']);
                        redirect(site_url('c=post&category_id='.$article['category_id']));
                }
                redirect(site_url('c=post'));
        }

        public function changeStatus() {
                $id = $this->input->get('id');
                $article = $this->article_model->getById(intval($id));
                if(!empty($article)){
                        $status = isset($article['status']) && $article['status'] == 1 ? 0 : 1;
                        $this->article_model->updateArticle(array('status' => $status), array('id'=>$id));
                        redirect(site_url('c=post&category_id='.$article['category_id']));
                }
                redirect(site_url('c=post'));
        }

        public function _getCreateArticle($post) {
                $article = array();
                $article['title'] = isset($post['title']) ? htmlspecialchars($post['title']) : '';
                $article['category_id'] = isset($post['category_id']) && is_numeric($post['category_id']) ? intval($post['category_id']) : 0;
                $article['author'] = isset($post['author']) ? htmlspecialchars($post['author']) : '';
                $article['summary'] = isset($post['summary']) ? htmlspecialchars($post['summary']) : '';
                $article['keywords'] = isset($post['keywords']) ? htmlspecialchars($post['keywords']) : '';
                $article['come_from'] = isset($post['come_from']) ? $post['come_from'] : '';
                $article['content'] = isset($post['content']) ? $post['content'] : '';
                $article['add_time'] = isset($post['add_time']) ? $post['add_time'] : '';
                $article['add_time'] = strtotime($article['add_time']);
                $article['edit_time'] = $article['add_time'];
                $article['status'] = isset($post['status']) ? intval($post['status']) : 0;
                $article['hits'] = 0;
                $article['zan'] = 0;
                $article['is_delete'] = 0;
                return $article;
        }

        public function _getUpdateArticle($post) {
                $article = array();
                $article['title'] = isset($post['title']) ? htmlspecialchars($post['title']) : '';
                $article['category_id'] = isset($post['category_id']) && is_numeric($post['category_id']) ? intval($post['category_id']) : 0;
                $article['author'] = isset($post['author']) ? htmlspecialchars($post['author']) : '';
                $article['summary'] = isset($post['summary']) ? htmlspecialchars($post['summary']) : '';
                $article['come_from'] = isset($post['post']) ? $post['post'] : '';
                $article['keywords'] = isset($post['keywords']) ? htmlspecialchars($post['keywords']) : '';
                $article['content'] = isset($post['content']) ? $post['content'] : '';
                $article['edit_time'] = time();
                $article['status'] = isset($post['status']) ? intval($post['status']) : 0;
                return $article;
        }

}