<?php

defined('APPPATH') or exit('forbidden to access');

class Article_category extends MY_Controller {

	public $tpl_path_form = 'default/article_cat_form_view';

	public function __construct() {
		parent::__construct();

		$this->load->model('article_cat_model');
	}

	public function index() {
		$view_data['module_name'] = '文章类别树形表';
		$view_data['module_desc'] = '';
		$cat_tree = $this->article_cat_model->get_tree();

		$view_data['cat_tree'] = $cat_tree;
		$this->_load_view('default/article_cat_browse_view', $view_data);
	}

	public function create() {
		$view_data['module_name'] = '文章类别添加';
		$view_data['module_desc'] = '';
		$view_data['post_url'] = site_url('c=article_category&m=create');

		$post = $this->input->post();
		if( ! empty($post)) {
			//post

			if( ! $this->_validate_form()) {
				$this->_load_view('default/article_cat_form_view', $view_data);
				return ;
			}

			$id = intval($post['id']);
			$cat_id = intval($post['cat_id']);
			$name = $this->input->post('name',  TRUE);
			$fid = intval($post['fid']);
			$status = intval($post['status']);
			$summary = isset($post['summary']) ? $post['summary'] : '';

			$insert_article_cat = array(
				'cat_id'	=> $cat_id,
				'id'		=> $id,
				'name'		=> $name,
				'fid'		=> $fid,
				'status'	=> $status,
				'summary'	=> $summary,
				'is_delete'	=> NO,
				);
			$insert_id = $this->article_cat_model->create($insert_article_cat);
			set_flashalert('添加父类成功' . $insert_id);
			redirect(site_url('c=article_category&m=index'));
		}else{
			//page
			$view_data['parents'] = $this->article_cat_model->get_tree();
			$this->_load_view('default/article_cat_form_view', $view_data);
		}

	}


	//v2 编辑文章分类
	public function edit() {
		$view_data['module_name'] = '文章分类编辑';
		$view_data['module_desc'] = '';
		$view_data['post_url'] = site_url('c=article_category&m=edit');

		$post = $this->input->post();

		if( ! empty($post)) {
			if( ! $this->_validate_form()) {
				$this->_load_view($this->tpl_path_form, $view_data);
				return ;
			}

			$id = intval($post['id']);
			$cat_id = intval($post['cat_id']);
			$name = $this->input->post('name',  TRUE);
			$fid = intval($post['fid']);
			$status = intval($post['status']);
			$summary = isset($post['summary']) ? $post['summary'] : '';

			$update_article_cat = array(
				'cat_id'		=> $cat_id,
				'name'		=> $name,
				'fid'		=> $fid,
				'status'	=> $status,
				'summary'	=> $summary,
				);
			var_dump($id);
			var_dump($update_article_cat);

			$affected_rows = $this->article_cat_model->update_by_id($update_article_cat, $id);
			set_flashalert('修改文章分类成功');
			redirect(site_url('c=article_category&m=index'));
		}else{
			$article_cat_id = $this->input->get('id');
			if($article_cat_id === NULL || !is_numeric($article_cat_id)) {
				show_error('文章分类ID不正确');
			}

			$article_cat_id = intval($article_cat_id);
			$article_cat = $this->article_cat_model->get_by_id($article_cat_id);
			if($article_cat === NULL) {
				show_error('文章分类不存在');
			}

			$_POST = array_merge($_POST, 
				array(
					'id'		=> $article_cat['id'],
					'cat_id'	=> $article_cat['cat_id'],
					'name'		=> $article_cat['name'],
					'fid'		=> $article_cat['fid'],
					'status'	=> $article_cat['status'],
					'summary'	=> $article_cat['summary'],
					));

			$this->_load_view($this->tpl_path_form, $view_data);
		}

	}


	//v2，检查表单提交是否正确。
	public function _validate_form() {

		$this->load->library('form_validation', $this->config->item('form_validation'));
		$form_valid_config = array(
			array(
				'field'	=> 'cat_id',
				'label'	=> '分类ID',
				'rules'	=> 'required|is_natural_no_zero',
				),
			array(
				'field' => 'name',
				'label' => '分类名称',
				'rules'	=> 'required',
				),
			array(
				'field'	=> 'fid',
				'label'	=> '父级分类',
				'rules'	=> 'required',
				),
			array(
				'field' => 'status',
				'label'	=> '分类状态',
				'rules'	=> 'required',
				),
			);
		$this->form_validation->set_rules($form_valid_config);
		return $this->form_validation->run();
	}

	//v2 删除文章分类
	public function del() {
		$article_cat_ids_str = $this->input->get('article_cat_ids');
		if($article_cat_ids_str === NULL) {
			show_error('文章分类ID不正确');
		}

		$article_cat_ids = explode('_', $article_cat_ids_str);
		if( ! is_array($article_cat_ids)) {
			show_error('文章分类ID不正确');
		}
		$update_article_cat = array(
			'is_delete'	=> YES,
			);
		$affected_rows = $this->article_cat_model->update_by_ids($update_article_cat, $article_cat_ids);
		set_flashalert('删除文章文类成功');
		redirect(site_url('c=article_category&m=index'));
	}
}