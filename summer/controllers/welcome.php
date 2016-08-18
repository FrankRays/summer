<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Welcome extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('site_model');
		$this->load->model('article_model');
		$this->load->model('nav_model');
		$this->load->model('article_cat_model');
		$this->load->model('file_model');
		$this->load->model('slider_model');
	}

	public function index() {
		$this->site_model->increase_site_hits();

		$data_view['navs'] 		= $this->nav_model->get_list(1, 10, 0);
		$data_view['sliders']	= $this->slider_model->get_list(50, 0);

		//to get xueyuan dongtai
		$data_view['college_news_top'] = $this->article_model->get_top_list(1, 0, 2);
		$data_view['college_news'] = $this->article_model->get_front_list(9, 0, 2);

		$this->load->view('front/new_index_view', $data_view);
	}

	public function archive() {
		//如果是

		$view_data = array();
		$this->site_model->increase_site_hits();
		
		$artilce_segment_info = $this->uri->rsegment(3);
		if(! strpos($artilce_segment_info, '-')) {
			show_404();
		}

		$segment_info = explode('-', $artilce_segment_info);
		if(count($segment_info) == 2) {
			$article_id = intval($segment_info[1]);
			$category_id = intval($segment_info[0]);

			$article = $this->article_model->get_by_id($article_id);

			if(empty($article_id)) {
				show_404();
			}

			$article['imgs'] = $this->file_model->get_imgs_by_object_id($article['id']);
			$view_data['article'] = $article;
			$view_data['title'] = $article['title'];
			$view_data['navs'] = $this->nav_model->get_list(1, 11, 0);
			$view_data['bread_path'] = $this->article_cat_model->get_nav_path(15);
			$view_data['next_article'] = $this->article_model->get_next_article($article['id']);
			$view_data['prev_article'] = $this->article_model->get_prev_article($article['id']);
		}

		$this->load->view('front/archive_view', $view_data);
	}

	public function li() {
		$category_id = $this->uri->rsegment(3);
		$offset = $this->input->get('offset');

		if(empty($category_id) || ! is_numeric($category_id) || $category_id <= 0) {
			$category_id = 1;
		}else{
			$category_id = intval($category_id);
		}

		if(empty($offset) || ! is_numeric($offset)) {
			$offset = 0;
		}else{
			$offset = intval($offset);
		}



		$article_cat = $this->article_cat_model->get_by_id($category_id);
		if(empty($article_cat)) {
			show_404();
		}

		$page_config = $this->config->item('page_config');


		$cond = array(
			'category_id'	=> $article_cat['id'],
			);
		$page = $this->article_model->get_front_pages(20, $offset);
		$page_config['total_rows'] = $page['total_rows'];
		$page_config['base_url'] = site_url('l/'.$category_id);
		$this->load->library('pagination');
		$this->pagination->initialize($page_config);


		$view_data['articles'] 			= $page['data_list'];
		$view_data['pager'] 			= $this->pagination->create_links();
		$view_data['title'] 			= $article_cat['name'] . '-' . $this->site_model->get_site_name(1);
		$view_data['bread_path'] 		= $this->article_cat_model->get_nav_path($article_cat['id']);
		$view_data['navs'] = $this->nav_model->get_list(1, 11, 0);

		$this->load->view('front/li_view', $view_data);
	}

	//文章赞 json 接口
	public function do_like_ajax() {
		$this->output->set_header('Content-Type:text/html;charset=utf-8');
		$this->output->set_header('Content-type: application/json');
		$article_id = $this->input->get('article_id');
		if(empty($article_id)) {
			echo '{"status" : 500, "message" : "文章ID不存在"}';
			exit();
		}else{
			$article_id = intval($article_id);
		}

		$ip_addr = $this->input->ip_address();
		$this->load->model('article_love_model');
		if($this->article_love_model->is_love($article_id, $ip_addr)) {
			echo '{"status" : 500, "message" : "你已经赞过了"}';
		}else{
			$this->article_love_model->increase_artilce_love($article_id, $ip_addr);
			echo '{"status" : 200, "message" : "赞成功"}';
		}
	}

	public function m_index() {
		$view_data = array();
		$this->load_model('slider_model');
		$sliders = $this->slider_model->get_list(10, 0);
		
	}

}