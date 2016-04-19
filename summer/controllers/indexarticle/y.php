<?php
	
class y extends Ykj_Controller{
	//模板数组
	private $tpl;

	public function __construct(){
		parent::__construct();

		$this -> tpl = array(
			'browse' => 'v_01/index_manage/browse_view',
			'setCoverimg' => 'v_01/index_manage/setCoverimg_view',
			'crawler' => 'v_01/index_manage/crawler_view',
			'indexNewsStatistics' => 'v_01/index_manage/crawler_statistics_view'
			);

		//初始化分页信息
		$this -> pageNum = 15;
		//载入工具类
		$this -> load ->helpers();
		$this -> load -> library('pagination');
		$this -> load -> model('news_index_model');
		$this -> load -> library('JsonOutUtil');
		$this -> jsonOutUtil = new JsonOutUtil();

		//potal
		$this -> yPotal();
	}

	public function index(){
		$this -> _data['content']['moduleName'] = '学院首页新闻管理';
		$this -> _data['content']['moduleDesc'] = '设置学院首页新闻在新闻网上的置顶信息和图片信息';
		$this -> _data['sidebar'] = array();
		$this -> _data['foot'] = array();

		$get = $this -> input -> get();
		$page = isset($get['page']) && is_numeric($get['page']) ?
			intval($get['page']) - 1 : 0;
		$category_id = isset($get['category_id']) && is_numeric($get['category_id']) ?
			intval($get['category_id']) : 1;

		$this -> _data['content']['pagination'] 
			= $this -> _getPaginationStr($this -> news_index_model -> getTotal(array('category_id' => $category_id)));
		$this -> _data['content']['articles'] = 
			$this -> news_index_model -> get($this -> pageNum, ($this -> pageNum * $page), 
				array('category_id' => $category_id));

		$this -> _view($this -> tpl['browse']);
		
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
		$this -> _data['content']['moduleName'] = '设置置顶图片';
		$this -> _data['content']['moduleDesc'] = '设置首页新闻的置顶图片';

		$post = $this -> input -> post();
		$get = $this -> input -> get();
		if(empty($post)){
			$id = isset($get['id']) ? stripslashes($get['id']) : "";
			$article = $this -> news_index_model -> get(1, 0, array('id' => $id)); 
			$this -> _data['content']['article'] = $article[0];
			$this -> _view($this -> tpl['setCoverimg']);
			return ;
		}else{
			if($this -> news_index_model -> setCoverImg($post)){
				$this -> jsonOutUtil -> resultOutString(true,
					array('msg' => '保存成功'));
				return ;
			}else{
				$this ->  jsonOutUtil -> resultOutString(false,
					array('msg' => '保存失败'));
			}
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

	// public function test() {
	// 	$this -> news_index_model -> doCrawl();
	// }

	public function del() {
		$id = $this->input->get('id');
		$this->news_index_model->del($id);
		redirect(site_url("d=indexArticle&c=y&m=index"));
	}
}