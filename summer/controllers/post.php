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
        $this->load->model('user_model');
	}

	public function index() {
		$this->browse();
	}

    //首页
	public function browse() {
        if( ! $this->user_model->verify()) redirect('c=user&m=login');
		$data['moduleName'] = '文章管理';
		$data['moduleDesc'] = '管理多媒体文章信息';

		$get = $this->input->get();

        $cond = array();
        $category_id = 0;
        if( isset($get['category_id']) && is_numeric($get['category_id'])) {
            $category_id = intval($get['category_id']);
            $_POST['category_id'] = $category_id . '';
            $cond['category_id'] = $category_id;
        }

        $offset = 0;
        if(isset($get['offset']) && is_numeric($get['offset'])) {
            $offset = intval($get['offset']);
        }

		$page_config = $this->config->item("page_config");
		$page = $this->article_model->get_pages($offset, $page_config['per_page'], $cond);

		$page_config['base_url'] = deal_page_base_url();
		$page_config['total_rows'] = $page['total_rows'];
		$this->pagination->initialize($page_config);

		$data['pagination']         = $this->pagination->create_links();
        $data['categories']         = $this->article_cat_model->get_tree();
        $data['data_list']          = $page['data_list'];
        $data['page']               = $page;
        $data['category']           = $this->news_category_model->get_by_id($category_id);
        $data['wq']                 = isset($_GET['wq']) ? $_GET['wq'] : '';

        $this->_load_view('default/article_browse_view', $data);
	}

    //增加和修改文章
    public function save() {
        $this->_verify();
        $view_data['moduleName'] = '增加文章';
        $view_data['moduleDesc'] = '增加文章';

        if( ! empty($_POST)) {
            if($this->_check_form()) {
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
                $publish_date = $this->input->post('publish_date');
                $create_date = $publish_date;
                $status = $this->input->post('status');
                $come_from = $this->input->post('redirect_come_from');
                $come_from_url = $this->input->post('redirect_come_from_url');
                $is_redirect = $this->input->post('is_redirect');

                if( ! empty($is_redirect)) {
                    $save_article = array(
                        'title'         => $title,
                        'category_name' => $category['name'],
                        'category_id'   => $category['cat_id'],
                        'is_redirect'   => YES,
                        'come_from'     => $come_from,
                        'come_from_url' => $come_from_url,
                        'status'        => $status,
                        'summary'       => $summary,
                        );
                }else{
                    $save_article = array(
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
                        'is_redirect'       => NO,
                        );

                }
                if(isset($post['id']) && ! empty($post['id'])) {
                    //update article
                    $article_id = intval($this->input->post('id'));
                    $affected_rows = $this->article_model->update_by_id($save_article, $article_id);
                    set_flashalert('修改文章成功，去预览下你修改的文章是否正确吧');
                }else{
                    //insert article
                    //
                    $create_time = date(TIME_FORMAT);
                    $save_article = array_merge($save_article, array(
                        'create_time'       => $create_time,
                        'create_date'       => $create_time,
                        'edit_time'         => $create_time,
                        'publish_date'      => $create_time,
                        ));
                    $insert_id = $this->article_model->create($save_article);
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
                            'publish_date'  => $article['publish_date'],
                            'is_redirect'   => array($article['is_redirect']),
                            'redirect_come_from'        => $article['come_from'],
                            'redirect_come_from_url'    => $article['come_from_url'],
                            ));
                    $view_data['content'] = $article['content'];
                }
        }

        $categories = $this->article_cat_model->get_tree();
        $view_data['categories'] = $categories;
        $this->_load_view('default/article_create_view', $view_data);
    }


    //v2 添加文章
    public function article_create() {
        $this->_verify();
        $view_data['module_name'] = '添加文章';
        $view_data['moduleName'] = $view_data['module_name'];

        $view_data['categories'] = $this->article_cat_model->get_tree();

        if($_POST) {
            if($this->_check_form()) {
                
                $category_id = intval($this->input->post('category_id'));
                $category = $this->article_cat_model->get_by_id($category_id);
                if($category == NULL) {
                    show_error('文章分类不存在');
                }

                $title          = $this->input->post('title', TRUE);
                $summary        = $this->input->post('summary', TRUE);
                $content        = $this->input->post('content');
                $author_name    = $this->input->post('author', TRUE);
                $keywords       = $this->input->post('keywords', TRUE);
                $publish_date   = $this->input->post('publish_date');
                $status         = $this->input->post('status');
                $come_from      = $this->input->post('redirect_come_from');
                $come_from_url  = $this->input->post('redirect_come_from_url');
                $is_redirect    = empty($this->input->post('is_redirect')) ? NO : YES;
                $create_time = date(TIME_FORMAT);

                $insert_article = array(
                    'title'         => $title,
                    'category_id'   => $category['id'],
                    'category_name' => $category['name'],
                    'summary'       => $summary,
                    'content'       => $content,
                    'author_name'   => $author_name,
                    'publisher_name'=> cur_user_account(),
                    'publisher_id'  => cur_user_id(),
                    'keywords'      => $keywords,
                    'publish_date'  => $publish_date,
                    'status'        => $status,
                    'come_from'     => $come_from,
                    'come_from_url' => $come_from_url,
                    'create_time'   => $create_time,
                    'create_date'   => $create_time,
                    );

                $this->article_model->create($insert_article);
                set_flashalert('添加文章成功');
                redirect(site_url('c=post'));
            }

            if( isset($_POST['content'])) {
                $view_data['content'] = $_POST['content'];
            }
        }else{

        }

        $this->_load_view('default/article_create_view', $view_data);
    }


    //v2 编辑文章
    public function article_edit() {
        //检查admin 登录
        $this->_verify();

        $view_data['module_name'] = '编辑文章';
        $view_data['moduleName'] = $view_data['module_name'];

        $view_data['categories'] = $this->article_cat_model->get_tree();
        if($_POST) {
            if($this->_check_form()) {
                $post = $this->input->post();

                $category_id = intval($post['category_id']);
                $category = $this->article_cat_model->get_by_id($category_id);
                if($category == NULL) {
                    show_error('文章分类不存在');
                }

                $article_id = $this->input->post('id');
                if(empty($article_id) || ! is_numeric($article_id)) {
                    show_error('文章ID不存在');
                }

                $title          = $this->input->post('title', TRUE);
                $summary        = $this->input->post('summary', TRUE);
                $content        = $this->input->post('content');
                $author_name    = $this->input->post('author', TRUE);
                $keywords       = $this->input->post('keywords', TRUE);
                $publish_date   = $this->input->post('publish_date');
                $status         = $this->input->post('status');
                $come_from      = $this->input->post('redirect_come_from');
                $come_from_url  = $this->input->post('redirect_come_from_url');
                $is_redirect    = empty($this->input->post('is_redirect')) ? NO : YES;

                $update_article = array(
                    'title'         => $title,
                    'category_id'   => $category['id'],
                    'category_name' => $category['name'],
                    'summary'       => $summary,
                    'content'       => $content,
                    'author_name'   => $author_name,
                    'keywords'      => $keywords,
                    'publish_date'  => $publish_date,
                    'status'        => $status,
                    'come_from'     => $come_from,
                    'come_from_url' => $come_from_url,
                    'is_redirect'   => $is_redirect,
                    );

                $this->article_model->update_by_id($update_article, intval($article_id));
                set_flashalert('修改文章成功，去预览下你修改的文章是否正确吧');
                redirect('c=post');
            }

        }else{
            $article_id = $this->input->get('article_id');
            if(empty($article_id) || ! is_numeric($article_id)) {
                show_error('文章ID错误');
            }

            $article_id = intval($article_id);
            $article = $this->article_model->get_by_id($article_id);

            if(empty($article)) {
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
                    'publish_date'  => $article['publish_date'],
                    'is_redirect'   => array($article['is_redirect']),
                    'redirect_come_from'        => $article['come_from'],
                    'redirect_come_from_url'    => $article['come_from_url'],
                    ));
            $view_data['content'] = $article['content'];
        }

        $this->_load_view('default/article_create_view', $view_data);
    }

    //设置文章图片
    public function imgs(){
        if( ! defined('ADMIN') or ! $this->user_model->is_admin()) redirect(site_url('c=user&m=login'));
        $view_data['module_name'] = '设置文章图片';

        if($_POST) {
            $object_id = $this->input->post('object_id');
            if(empty($object_id) or ! is_numeric($object_id)) {
                show_error('ID不存在');
            }else{
                $object_id = intval($object_id);
            }
            if($this->article_model->save_article_images()) {
                redirect(site_url('c=post&m=imgs&object_id='. $object_id));
            }
        }else{
            $object_id = $this->input->get('object_id');
        }

        if(empty($object_id) or ! is_numeric($object_id)) {
            show_error('文章ID不存在');
        }else{
            $object_id = intval($object_id);
        }

        $view_data['imgs']      = $this->file_model->get_imgs_by_object_id($object_id);
        $view_data['object_id'] = $object_id;
        $_POST['object_id']     = $object_id;
        $this->_load_view('default/article_imgs_view', $view_data);

    }

    public function imgs_edit() {
        if( ! defined('ADMIN') or ! $this->user_model->is_admin()) redirect(site_url('c=user&m=login'));
        $view_data['module_name']   = '图片修改';
        $view_data['post_url']      = site_url('c=post&m=imgs_edit');

        if($_POST) {
            $file = $this->article_model->update_article();
            if($file !== FALSE) {
                set_flashalert('修改图片成功');
                redirect(site_url('c=post&m=imgs&object_id=' . $file['object_id']));
                $id = $file['id'];
            }else{
                $id = $this->input->post('id');
            }

        }else{
            $id         = $this->input->get('id');
            $object_id  = $this->input->get('object_id');
        }

        if(empty($id)) {
            show_error('文件ID不存在');
        }

        $img = $this->file_model->get_by_id(intval($id));
        $_POST = $img;

        $view_data['bread_path']    = get_module_path(array(
            array('文章列表', site_url('c=post&m=index')),
            array('图片列表', site_url('c=post&m=imgs&object_id='.$img['object_id'])),
            array('更新图片', ''),
            ));
        $view_data['article_image'] = $img;
        $this->_load_view('default/article_imgs_edit_view', $view_data);
    }

    //删除用户图片
    public function del_img() {
        $file_id = $this->input->get('file_id');
        if(empty($file_id) || ! is_numeric($file_id)) {
            show_error('文件ID错误');
        }

        $img = $this->file_model->get_by_id(intval($file_id));
        if(empty($img)) {
            show_error('图片不存在');
        }

        $absolute_path = $this->config->item('resource_upload_path');
        $absolute_path = trim($absolute_path, '/') . '/' . $img['pathname'];
        if(file_exists($absolute_path) && is_readable($absolute_path)) {
            unlink($absolute_path);
        }

        $this->file_model->del_by_id($img['id']);

        redirect(site_url('c=post&m=imgs&object_id='.$img['object_id']));
        set_flashalert('删除图片成功');
    }


    //讲文章设置为置顶
    public function setTop() {
        $this->_verify();
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
        $this->_verify();
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

    //v2 设置封面图片
    public function set_cover_img() {
        $file_id = $this->input->get('file_id');
        if(empty($file_id) || ! is_numeric($file_id)) {
            show_error('图片ID错误');
        }

        $img = $this->file_model->get_by_id(intval($file_id));
        if(empty($img)) {
            show_error('图片信息不存在');
        }

        $article = $this->article_model->get_by_id($img['object_id']);
        if(empty($article)) {
            show_error('文章不存在');
        }

        //取消所有的封面
        $imgs = $this->file_model->get_imgs_by_object_id($img['object_id']);

        $update_img = array(
            'primary'    => 0,
            );
        if(is_array($imgs)) {
            foreach($imgs as $v) {
                $this->file_model->update_by_id($update_img, $v['id']);
            }
        }

        $update_img = array(
            'primary'    => 1,
            );
        $this->file_model->update_by_id($update_img, $img['id']);

        $update_article = array(
            'coverimg_path'     => $img['pathname'],
            );
        $this->article_model->update_by_id($update_article, $img['object_id']);
        redirect(site_url('c=post&m=imgs&object_id=' . $img['object_id']));
        set_flashalert('设置封面图片成功');

    }


    //v2, 检查表单提价欧是否合法
    public function _check_form() {
        $this->_verify();
        $this->form_validation->set_rules(
            array(
                array(
                    'field'     => 'title',
                    'label'     => '标题',
                    'rules'     => 'required|min_length[1]|max_length[255]',
                    ),
                array(
                    'field'     => 'category_id',
                    'label'     => '分类',
                    'rules'     => 'required|callback__hasCategory',
                    ),
                array(
                    'field'     => 'status',
                    'label'     => '状态',
                    'rules'     => 'required|in_list[0,1]',
                    ),
                array(
                    'field'     => 'is_redirect',
                    'label'     => '跳转',
                    'rules'     => '',
                    ),
                array(
                    'field'     => 'summary',
                    'label'     => '摘要',
                    'rules'     => 'required',
                    )
                )
            );

        //更新文章检查id值是否正确
        $id = $this->input->post('id');
        if( ! empty($id)) {
            $this->form_validation->set_rules('id', '文章ID', 'is_natural_no_zero');
        }
        
        $is_redirect = $this->input->post('is_redirect');
        if( ! empty($is_redirect) && $is_redirect == YES) {
            $this->form_validation->set_rules('redirect_come_from', '转载自', 'required');
            $this->form_validation->set_rules('redirect_come_from_url', '转载连接', 'required|valid_url');
        }

        return $this->form_validation->run();
    }


    //批量删除
    public function del() {
        $this->_verify();
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

    //改变文章状态
    public function changeStatus() {
        $this->_verify();
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