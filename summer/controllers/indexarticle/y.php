<?php
	
class y extends MY_Controller{
	//模板数组
	private $tpl;

	//学院新闻连接
	public $xyxw_list_url = 'http://www.svtcc.edu.cn/front/list-11.html';
	//系部新闻连接
	public $xbxw_list_url = 'http://www.svtcc.edu.cn/front/list-16.html';
	//通知公告连接
	public $notice_list_url = 'http://www.svtcc.edu.cn/front/list-12.html';

	public function __construct(){
		parent::__construct();

		$this -> tpl = array(
			'browse' => 'v_01/index_manage/browse_view',
			'setCoverimg' => 'v_01/index_manage/setCoverimg_view',
			'crawler' => 'v_01/index_manage/crawler_view',
			'indexNewsStatistics' => 'v_01/index_manage/crawler_statistics_view'
			);

		//载入工具类
		$this->load->helper('summer_view');
		$this -> load -> library('pagination');
		$this -> load -> model('news_index_model');
		$this -> load -> library('JsonOutUtil');
		$this -> jsonOutUtil = new JsonOutUtil();

	}

	public function index(){
		$data['moduleName'] = '学院首页新闻管理';
		$data['moduleDesc'] = '设置学院首页新闻在新闻网上的置顶信息和图片信息';

		//get flash data of save
		$data['save_status'] = isset($_SESSION['save_status']) ? $_SESSION['save_status'] : 0;
        $data['save_message'] = isset($_SESSION['save_message']) ? $_SESSION['save_message'] : '';

		$get = $this->input->get();
		$offset = isset($get['offset']) && is_numeric($get['offset']) ? intval($get['offset']) : 0;
		$category_id = isset($get['category_id']) && is_numeric($get['category_id']) ? intval($get['category_id']) : 1;

		$cond = array();
		if(!empty($category_id)) {
			$cond['category_id'] = $category_id;
		}
		$pgCfg = $this->config->item('paginationConfig', 'snowConfig/admin');
		$page = $this->news_index_model->getPage($offset, $pgCfg['per_page'], $cond);

		//create pagination links
		if(isset($get['offset'])) {
			unset($get['offset']);
		}
		$baseUrl = array();
		foreach($get as $k=>$v){
			$baseUrl[] = $k . '=' . $v;
		}
		$pgCfg['base_url'] = site_url(implode($baseUrl, '&'));
		$pgCfg['total_rows'] = $page['count'];
		$this->pagination->initialize($pgCfg);
		$data['pagination'] = $this->pagination->create_links();
		$data['page'] = $page;

		$this->_loadView('v_01/index_manage/browse_view', $data);
	}

	public function setTop(){
		$post = $this -> input -> post();

		$id = isset($post['id']) ? stripslashes($post['id']) : "";
		// $id = isset($post['id']) && is_numeric($post['id']) ?
		// 	intval($post['id']) : 0;

		$result = $this -> news_index_model -> setTop($id);
		if($result == 1){
			$this -> jsonOutUtil -> resultOutString(true,
				array('msg' => '设置置顶成功'));
		}else if($result == 2){
			$this -> jsonOutUtil -> resultOutString(false,
				array('msg' => '设置失败,设置为置顶的图片必须有上传的封面图片'));
		}
	}

	public function setCoverImg(){
		$data['moduleName'] = '设置置顶图片';
		$data['moduleDesc'] = '设置首页新闻的置顶图片';


		$post = $this->input->post();
		if(empty($post)){
			//page of upload cover img
			$get = $this->input->get();
			$id = isset($get['id']) ? stripslashes($get['id']) : "";
			if(empty($id)) {
				show_404();
				return;
			}
			$data['indexArticle'] = $this->news_index_model->getById($id);
			if(empty($data['indexArticle'])) {
				show_404();
				return;
			}else{
				$_POST = array_merge($data['indexArticle'], $_POST);
				$this->_loadView('v_01/index_manage/setCoverimg_view', $data);
			}
		}else{
			//save the cover img post action 
			$id = $this->input->post('id');
			$coverImg = $this->input->post('coverImg', true);
			$indexNews['cover_img'] = $coverImg;
			$this->news_index_model->updateById($indexNews, $id);

			setFlashAlert(200, $this->lang->line('article_save_success'));
			redirect(site_url('d=indexArticle&c=y&m=index'));
		}
	}

	public function doCrawler(){
		$this -> _data['content']['moduleName'] = '搬运新闻';
		$this -> _data['content']['moduleDesc'] = '搬运首页数据';

		$this -> _view($this -> tpl['crawler']);
	}

	public function doCrawlerNew(){
		$this -> news_index_model -> doCrawl();
	}

	public function doCrawlNewPage(){
		$this -> news_index_model -> doCrawl();

		$this -> _data['content']['moduleName'] = '首页新闻统计';
		$this -> _data['content']['moduleDesc'] = '总数统计';

		$this -> _data['content']['total'] = $this -> news_index_model -> getTotal();
		$this -> _data['content']['groupTotal'] = 
			$this -> news_index_model -> getTotalByGroup();

		$this -> _view($this -> tpl['indexNewsStatistics']);
	}

	public function del() {
		$id = $this->input->get('id');
		if(!empty($id)) {
			$id = stripslashes($id);
			$this->news_index_model->del($id);
			setFlashAlert(200, $this->lang->line('article_delete_success'));
		}else{
			setFlashAlert(500, $this->lang->line('article_delete_fail'));
		}
		redirect(site_url("d=indexArticle&c=y&m=index"));
	}



	public function crawl_index_news() {
		$this->load->library('crawler');
		$force_update = 1;

		//学院新闻抓取
		$xyxw_list_content = $this->crawler->get_content($this->xyxw_list_url);
		//系部新闻抓取
		$xbxw_list_content = $this->crawler->get_content($this->xbxw_list_url);
		//通知公告抓取
		$notice_list_content = $this->crawler->get_content($this->notice_list_url);

		$xyxw_url_arr = $this->crawler->handle_view_li_page($xyxw_list_content);
		$xbxw_url_arr = $this->crawler->handle_view_li_page($xbxw_list_content);
		$notice_list_arr = $this->crawler->handle_view_li_page($notice_list_content);

		$xyxw_url_arr = array_merge($xyxw_url_arr, $xbxw_url_arr);
		$xyxw_url_arr = array_merge($xyxw_url_arr, $notice_list_arr);
		$fail_num = 0;
		foreach($xyxw_url_arr as $v) {
			$success = preg_match('/(\d{2})-([\s\S]+?)\./', $v, $matched);
			if( ! $success) {
				$fail_num += 1;
				continue;
			}
			$category_id = $matched[1];
			$id = $matched[2];
			$old_article = $this->news_index_model->get_by_index_id($id);

			//crawle the article
			$article_content = $this->crawler->get_content($v);
			$article = $this->crawler->handle_view_content_page($article_content);
			//替换图片为首页资源地址
			$article['content'] = $this->_change_article_imgsrc_to_absorlute_index($article['content']);
			//获取文章summay
			$article['summary'] = $this->_get_article_summary($article['content']);

			if( ! $old_article) {
				//insert
				$insert_article = array(
					'id'			=> $id,
					'category_id'	=> $category_id,
					'title'			=> $article['title'],
					'create_date'	=> $article['create_date'],
					'publisher'		=> $article['publisher'],
					'hits'			=> $article['article_hits'],
					'fingerprint'	=> md5($article['content'] . $article['create_date'] . $article['title']),
					'content'		=> $article['content'],
					'summary'		=> $article['summary'],
					);

				$this->news_index_model->create($insert_article);
			} else {
				//update
				if( ! $article ) {
					$fail_num += 1;
					continue;
				}

				$fingerprint = md5($article['content'] . $article['create_date'] . $article['title']);
				if( $fingerprint == $old_article['fingerprint'] && $force_update == 0) {
					// no change skep this handle
					continue;
				}

				$update_article = array(
					'category_id' 	=> $category_id,
					'title'			=> $article['title'],
					'create_date'	=> $article['create_date'],
					'publisher'		=> $article['publisher'],
					'content'		=> $article['content'],
					'summary' 		=> $article['summary'],
					);

				$this->news_index_model->update_by_id($update_article, $id);
			}

			// var_dump($old_article);
			// break;
		}

		echo json_encode(array(
			'total' 	=> count($xyxw_url_arr),
			'fail'		=> $fail_num,
			));
	}

	private function _get_article_summary($content) {
		//获取文章的描述字段
		$clearly_content = strip_tags($content);
		$clearly_content = preg_replace('/\s/', '', $clearly_content);
		if(mb_strlen($clearly_content) > 40) {
			$summary = mb_substr($clearly_content, 0, 40) . '...';
		}else{
			$summary = $content;
		}

		return $summary;
	}

	private function _change_article_imgsrc_to_absorlute_index($content) {
			return preg_replace('/<img.*?src="(.*?)".*?>/',
			 '<img src="http://www.svtcc.edu.cn/$1" />', $content);
	}
}