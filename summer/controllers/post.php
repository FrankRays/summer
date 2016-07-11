<?php defined('BASEPATH') || exit('no direct script access allowed');

class post extends MY_controller {

	//设置封面图片的路径
	public $tpl_path_set_coverimg = 'default/article_set_coverimg_view';

	public function __construct() {
		parent::__construct();

		$this->load->model('news_category_model');
        $this->load->model('article_cat_model');
        $this->load->model('article_model');
		$this->load->model('file_model');
	}

	public function index() {
		$this->browse();
	}

	public function browse() {
		$data['moduleName'] = '文章管理';
		$data['moduleDesc'] = '管理多媒体文章信息';
        //set flash session data
        $data['save_status'] = isset($_SESSION['save_status']) ? $_SESSION['save_status'] : 0;
        $data['save_message'] = isset($_SESSION['save_message']) ? $_SESSION['save_message'] : '';

		$get = $this->input->get();

        $cond = array();
        $category_id = 0;
        if( isset($get['category_id']) && is_numeric($get['category_id'])) {
            $category_id = intval($get['category_id']);
            $_POST['category_id'] = $category_id;
            $cond['category_id'] = $category_id;
        }

        $offset = 0;
        if(isset($get['offset']) && is_numeric($get['offset'])) {
            $offset = intval($get['offset']);
        }

		$pgCfg = $this->config->item("page_config");
		$page = $this->article_model->get_pages($offset, $pgCfg['per_page'], $cond);
		$data['data_list'] = $page['data_list'];
        $data['page'] = $page;
		$categories = $this->article_cat_model->get_tree();

        $data['categories'] = $categories;
		if (isset($get['offset'])) {
			unset($get['offset']);
		}
		$baseUrl = array();
		foreach ($get as $key => &$value) {
			$baseUrl[] = $key . '=' . $value;
		}
		$pgCfg['base_url'] = site_url(implode($baseUrl, '&'));
		$pgCfg['total_rows'] = $page['total_rows'];
		$this->pagination->initialize($pgCfg);
		$data['pagination'] = $this->pagination->create_links();
        $category = $this->news_category_model->getById($category_id);
        $this->_load_view('default/article_browse_view', $data);
	}

    public function save() {
        $view_data['moduleName'] = '增加文章';
        $view_data['moduleDesc'] = '增加文章';
        $category_id = null;
        if( ! empty($_POST)) {
            $this->config->load('snowConfig/form_validation');
            $this->load->library('form_validation', $this->config->item('form_validation'));
            $this->form_validation->set_rules('title', '标题', 'trim|required|min_length[1]|max_length[50]');
            $this->form_validation->set_rules('category_id', '分类', 'trim|required|callback__hasCategory');
            $this->form_validation->set_rules('status', 'trim|required|in_list(0, 1)');
            //action
            //
            if($this->form_validation->run()) {
                $post = $this->input->post();
                $category_id = intval($post['category_id']);
                $category = $this->article_cat_model->get_by_cat_id($category_id);
                if($category == NULL) {
                    show_error('文章分类不存在');
                }

                $title = $this->input->post('title', TRUE);
                $summary = $this->input->post('summary', TRUE);
                $content = $this->input->post('content');
                $publisher_name = $this->input->post('come_from', TRUE);
                $author_name = $this->input->post('author', TRUE);
                $keywords = $this->input->post('keywords', TRUE);
                $publish_date = $this->input->post('add_time');
                $create_date = $publish_date;
                $status = $this->input->post('status');

                if(isset($post['id']) && ! empty($post['id'])) {
                    //update article
                    if( ! is_numeric($post['id'])) {
                        show_error('文章ID错误 : ' . $post['id']);
                    }

                    $article_id = intval($post['id']);
                    $update_article = array(
                        'title'             => $title,
                        'category_id'       => $category['cat_id'],
                        'category_name'     => $category['name'],
                        'publisher_name'    => $publisher_name,
                        'author_name'       => $author_name,
                        'summary'           => $summary,
                        'keywords'          => $keywords,
                        'content'           => $content,
                        'publish_date'      => $publish_date,
                        'status'            => $status,
                        );

                    $affected_rows = $this->article_model->update_by_id($update_article, $article_id);
                    set_flashalert('修改文章成功，去预览下你修改的文章是否正确吧');
                }else{
                    //insert article
                    $insert_article = array(
                        'title'             => $title,
                        'category_id'       => $category['cat_id'],
                        'category_name'     => $category['name'],
                        'publisher_name'    => $publisher_name,
                        'author_name'       => $author_name,
                        'summary'           => $summary,
                        'keywords'          => $keywords,
                        'content'           => $content,
                        'create_time'       => date(TIME_FORMAT),
                        'create_date'       => date(TIME_FORMAT),
                        'edit_time'         => date(TIME_FORMAT),
                        'publish_date'      => $publish_date,
                        'status'            => $status,
                        'is_delete'         => NO,
                        'is_top'            => NO,
                        );
                    $insert_id = $this->article_model->create($insert_article);
                    set_flashalert('添加文章成功, 去预览下你添加的文章是否正确吧！');
                }
                redirect(site_url('c=post&m=index'));
                return ;
            }
        }else{
                //page
                $article_id = $this->input->get('id');
                if($article_id == NULL) {
                    //insert_page
                }else{
                    //update_page
                    if( ! is_numeric($article_id)) {
                        show_error('文章ID错误');
                    }

                    
                    $article_id = intval($article_id);
                    $article = $this->article_model->get_by_id($article_id);
                    if($article == NULL) {
                        show_error('文章不存在');
                    }
                    $_POST = array_merge($_POST, 
                        array(
                            'id'            => $article['id'],
                            'title'         => $article['title'],
                            'category_id'   => $article['category_id'],
                            'summary'       => $article['summary'],
                            'keywords'      => $article['keywords'],
                            'come_from'     => $article['publisher_name'],
                            'author'        => $article['author_name'],
                            'content'       => $article['content'],
                            'status'        => $article['status'],
                            'add_time'      => $article['publish_date'],
                            ));
                    $view_data['content'] = $article['content'];
                }
        }

        $categories = $this->article_cat_model->get_tree();
        $view_data['categories'] = $categories;
        $this->_load_view('default/article_create_view', $view_data);
    }

    public function setTop() {
        $id = $this->input->get('id', true);
        if( $id === NULL && ! is_numeric($id)) {
            show_error('文章ID错误');
        }

        $article_id = intval($id);
        $article = $this->article_model->get_by_id($article_id);
        if($article === NULL) {
            show_error('文章不存在');
        }
        if(intval($article['is_top']) === YES) {
            $update_article['is_top'] = NO;
        }else{
            $update_article['is_top'] = YES;
        }

        $affected_rows = $this->article_model->update_by_id($update_article, $article_id);
        if($affected_rows === 0) {
            show_error('设置文章置顶失败');
        }

        set_flashalert('设置文章置顶成功');
        redirect(site_url('c=post&m=index'));
        return ;
    }



    //设置文章封面图片
    public function set_coverimg() {
        $view_data['module_name'] = '设置封面图片';
        $view_data['module_desc'] = '';

        $post = $this->input->post();
        if(empty($post)) {
            //get页面
            $get = $this->input->get();
            if( ! isset($get['id']) || ! is_numeric($get['id'])) {
                show_error('文章ID错误');
            }

            $article_id = intval($get['id']);
            $article = $this->article_model->get_by_id($article_id);

            if( ! $article) {
                show_error('文章不存在');
            }

            $_POST = array_merge($article);
            $this->_load_view($this->tpl_path_set_coverimg, $view_data);

        }else{
            //提交页面
            //http://127.0.0.1:9999/xww/resource/2016/07/5a84dbf997493b9dd2ef73166406a102_960x640.jpg
            // $post['coverimg_path'] = 'http://127.0.0.1:9999/xww/resource/2016/07/5a84dbf997493b9dd2ef73166406a102_960x640.jpg';
           


            $this->load->library('form_validation', $this->config->item('form_validation'));
            $this->form_validation->set_rules('coverimg_path', '封面图片路径', 'required');
            $this->form_validation->set_rules('id', '文章ID', 'required|is_natural_no_zero');

            if( ! $this->form_validation->run()) {
            	$this->_load_view($this->tpl_path_set_coverimg, $view_data);
            	return;
            }

            $article_id = intval($post['id']);

            $relative_path = trim(str_replace(base_url(), '', $post['coverimg_path']), '/');
            //插入到资源表
            
            $update_article = array(
                'coverimg_path' => $relative_path,
                );

            $affected_rows = $this->article_model->update_by_id($update_article, $article_id);
            set_flashalert('添加文章封面成功');
            redirect(site_url('c=post&m=index'));
        }
    }

    public function del() {
        $article_ids_str = $this->input->get('article_ids');
        if($article_ids_str === NULL) {
            show_error('文章ID错误');
        }

        $article_ids = explode('_', $article_ids_str);
        if(is_array($article_ids) && count($article_ids)) {
            $update_article = array(
                'is_delete' => YES,
                );
            $affected_rows = $this->article_model->update_by_ids($update_article, $article_ids);
            set_flashalert('删除文章成功');
            redirect(site_url('c=post'));
            return ;
        }else{
            show_error('文章ID错误');
        }
    }

    public function changeStatus() {
            $id = $this->input->get('id');
            if($id == NULL || ! is_numeric($id)) {
                show_error('文章ID错误');
            }
            $article_id = intval($id);
            $article = $this->article_model->get_by_id($article_id);
            if($article === NULL) {
                show_error('文章不存在');
            }

            if(intval($article['status']) == ARTICLE_STATUS_PUBLIC) {
                $update_article = array('status'=>ARTICLE_STATUS_DRUFT);
            }else{
                $update_article = array('status'=>ARTICLE_STATUS_PUBLIC);
            }

            $this->article_model->update_by_id($update_article, $article_id);
            set_flashalert('修改文章状态成功');
            redirect(site_url('c=post'));
    }

        public function _createArticle() {

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
                $article['come_from'] = isset($post['come_from']) ? $post['come_from'] : '';
                $article['keywords'] = isset($post['keywords']) ? htmlspecialchars($post['keywords']) : '';
                $article['content'] = isset($post['content']) ? $post['content'] : '';
                $article['edit_time'] = time();
                $article['status'] = isset($post['status']) ? intval($post['status']) : 0;
                return $article;
        }

        public function _getCreatePhoto($post) {
                $photo = $this->_getCreateArticle($post);
                if(isset($post['article_image'])) {
                        $photos = json_decode($post['article_image']);
                        $photo['img_data'] = json_encode($photos);
                }
                return $photo;
        }

        public function _getUpdatePhoto($post) {
                $photo = $this->_getUpdateArticle($post);
                if(isset($post['article_image']))  {
                        $photos = json_decode($post['article_image']);
                        $photo['img_data'] = json_encode($photos);
                }

                return $photo;
        }


        public function _hasCategory($category_id) {
                if(isset($category_id) && !empty($category_id) && is_numeric($category_id) && $category_id > 0) {
                        return true;
                }else{
                        $this->form_validation->set_message('_hasCategory', $this->lang->line('error_category_required'));
                        return false;
                }
        } 

}