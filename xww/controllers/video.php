<?php defined('BASEPATH') || exit('no direct script access allowed');

class  video extends Ykj_controller{



	/*构造方法*/
	public function __construct(){
		parent::__construct();
		$this -> load -> model('news_model');
		$this -> load -> model('news_category_model');
		$this -> load -> model('student_model');
		$this -> load -> model('file_model');

		$this -> load -> helper('url');
		$this -> load -> library('pagination');
		$this -> load -> model('news_crawler_model');
	}

	public function index(){
		$head['basepath'] = 'xww/third_party/floatpic/';
		$this -> loadHeader(array('head' => $head));

		//获取图片列表数据
		$articles = $this -> news_model -> getListByCId(6);

		$data['articles'] = $articles;
		$recentList = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));

		foreach ($recentList as $key => $value) {
			if(mb_strlen($value['title']) > 20){
				$recentList[$key]['title'] = mb_substr($value['title'], 0, 20) . "..";
			}
		}

		$data['recentList'] = $recentList;
		$data['categoryList'] = $this -> news_category_model -> getById(6);
		$this -> load -> view('front/xww/video_list_view', array('data' => $data));

		$this -> loadFooter();
	}

	public function archive($id=0){
		$head['basepath'] = 'xww/third_party/floatpic/';
		$this -> loadHeader(array('head' => $head));

		if($id == 0 && !is_numeric($id)) return;

		$article = $this -> news_model -> getById($id);

		$recentList = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));
		
		$data['recentList'] = $recentList;
		$data['content'] = $article;
		$data['PreNext'] = $this -> news_model -> getPreNext($data['content']['news_id'], $data['content']['category_id']);

		if($article['is_video']) {
			$this->load->view('front/xww/news_archive_view', $data);
		} else {
			$data['article'] = $article;
			$this->load->view('front/xww/video_archive_view', array('data' => $data));
		}
		
		$this -> loadFooter();
	}

}