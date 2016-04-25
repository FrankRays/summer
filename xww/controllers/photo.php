<?php defined('BASEPATH') || exit('no direct script access allowed');

class  Photo extends Ykj_controller{



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

	public function index($categoryId = 0){
		$head['basepath'] = 'xww/third_party/floatpic/';
		$head['js'] = array(
			'js/jquery-1.9.1.min.js'
			);
		$this -> loadHeader(array('head' => $head));

		//获取图片列表数据
		if(!is_numeric($categoryId) || $categoryId == 0) return;

		$articles = $this -> news_model -> getPhotoNewsByCond(10, 0, array('category_id' => $categoryId));

		foreach ($articles as $key => $value) {
			if(mb_strlen($value['title']) > 14){
				$articles[$key]['title'] = mb_substr($value['title'], 0, 14) . "..";
			}
		}

		$data['category'] = $this->news_category_model->getById($categoryId);

		$data['articles'] = $articles;
		$recentList = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));
		foreach ($recentList as $key => $value) {
			if(mb_strlen($value['title']) > 22){
				$recentList[$key]['title'] = mb_substr($value['title'], 0, 22) . "..";
			}
		}

		$data['recentList'] = $recentList;
		$this -> load -> view('photonews/photo_browse_view', array('data' => $data));

		$this -> loadFooter();
	}

	public function archive($id=0, $index = 0){
		$head['basepath'] = 'xww/third_party/floatpic/';
		$this -> loadHeader(array('head' => $head));

		$index = intval($index);
		if($id == 0 && !is_numeric($id)) return;

		$article = $this -> news_model -> getPhotoById($id);
		$articles = $this -> news_model -> getPhotoNewsByCond(5, 0, array('category_id' => $article['category_id']));
		$this->news_model->add_hit($id);
		$picArr = json_decode($article['content'], true);
		if(count($picArr) < 1) {
			return ;
		}

		if($index >= count($picArr)) {
			$index = $picArr - 1;
		}

		$prePic = $index > 0 ? $index - 1 : 0;
		$nextPic = $index < count($picArr) - 1 ? $index + 1 : count($picArr) - 1;
		$data['prePic'] = site_url('/photo/archive/'.$article['news_id'].'/'.$prePic);
		$data['nextPic'] = site_url('photo/archive/'.$article['news_id'].'/'.$nextPic);
		$data['curPic'] = $picArr[$index];
		$data['article'] = $article;
		$data['articles'] = $articles;
		$data['cur_pic_index'] = $index;

		$this -> load -> view('photonews/photo_archive_view', array('data' => $data));
		$this -> loadFooter();
	}

}