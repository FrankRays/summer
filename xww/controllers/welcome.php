<?php defined('BASEPATH') || exit('no direct script access allowed'); 

class Welcome extends MY_controller{

	/*构造方法*/
	public function __construct(){
		parent::__construct();

		$this -> load -> model('news_model');
		$this -> load -> model('news_category_model');
		$this -> load -> model('friendlink_model');
		$this -> load -> model('lm_model');
		$this -> load -> model('file_model');
		$this -> load -> model('config_model');	
		$this -> load -> model('news_crawler_model');

		$this->load->model('article_model');
		$this->load->model('nav_model');

		$this -> load -> library('Crawler');
		$this->load->library('user_agent');
	}

	/*前台主控制器*/
	public function index(){

		//check mobile device
		if($this->agent->is_mobile()) {
			$navs = $this->nav_model->get_front_navs(1);
			$sliders = $this->config_model->getSlide();

			$cond = array(
					'is_top'	=> FALSE,
				);
			$xyxw_news = $this->news_crawler_model->get_xyxw_news_mobile(10, 0, $cond);

			$view_data = array(
				'navs'		=> $navs,
				'sliders'	=> $sliders,
				'xyxw_news'	=> $xyxw_news,
				);
			$this->load->view('mobile/welcome_view', $view_data);
			return ;
		}

		//bellow desktop handle

		$data = array();


		//lm管理
		$lmList = $this -> lm_model -> getList(10);
		foreach ($lmList as $key => $value) {
			if(empty($value['link_src']) && $value['cid'] != 0){
				$lmList[$key]['link_src'] = site_url('news/li/'.$value['cid']);
				$lmList[$key]['child'] = $this -> news_category_model -> getRecList($value['cid']);
			}else{
				preg_match_all("/http/", $value['link_src'], $match);
				if($value['link_src'] == 'site_url'){
					$lmList[$key]['link_src'] = site_url();
				}else if(!$match[0]){
					$lmList[$key]['link_src'] = site_url($value['link_src']);
				}
			}
		}
		$data['lmList'] = $lmList;

		//从首页取得学院新闻读取
		$xyxwNew = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));
		foreach ($xyxwNew as $key => $value) {
			if(mb_strlen($value['title']) > 15){
				$xyxwNew[$key]['title'] = mb_substr($value['title'], 0, 15). '...';
			}
			
			$xyxwNew[$key]["index_ctime"] = date("Y-m-d", $value["index_ctime"]);
		}

		//学院新闻
		$data['xyxw'] = $xyxwNew;

		//get xueyuanxinwen the top
		$cond = array(
			'category_id'	=> 1,
			'is_top'		=> 2
			);
		$data['xyxwFirst'] = $this -> news_crawler_model -> get(4, 0, $cond);

		$data['xyxwFirst'] = $data['xyxwFirst'][0];
		// var_dump($data['xyxwFirst']);
		if(mb_strlen($data['xyxwFirst']['title']) > 14){
			$data['xyxwFirst']['title']  = mb_substr($data['xyxwFirst']['title'], 0, 14) . "..";
		}

		// var_dump($data['xyxwFirst']);

		//系部动态
		$xbdt = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 3,
					'is_top <>' => 2));

		foreach ($xbdt as $key => $value) {
			if(mb_strlen($value['title']) > 17){
				$xbdt[$key]['title'] = mb_substr($value['title'], 0, 17). '...';
			}

			$xbdt[$key]["index_ctime"] = date("Y-m-d", $value["index_ctime"]);
		}

		$data['xbdt'] = $xbdt;
		//系部动态covernews
		$data['xbdtFirst'] = $this -> news_crawler_model -> get(4, 0, 
			array('category_id' => 3,
					'is_top' => 2));
		$data['xbdtFirst'] = $data['xbdtFirst'][0];

		if(mb_strlen($data['xbdtFirst']['title']) > 14){
			$data['xbdtFirst']['title']  = mb_substr($data['xbdtFirst']['title'], 0, 14) . "..";
		}

		//shrd
		$data['shrd'] = $this -> news_model -> getListByCId(3,5);
		foreach($data['shrd'] as $k => $v){
			$data['shrd'][$k]['add_time'] = date('Y-m-d', $v['add_time']);
			if(mb_strlen($v['title']) > 14){
				$data['shrd'][$k]['title'] = mb_substr($v['title'], 0, 14) . ".." ;
			}
		}

		//tongzhigonggao
		$data['tzgg'] = $this -> news_model -> getListByCId(10,4);
		foreach($data['tzgg'] as $k => $v){
			$data['tzgg'][$k]['add_time'] = date('Y-m-d', $v['add_time']);
			if(mb_strlen($v['title']) > 14){
				$data['tzgg'][$k]['title'] = mb_substr($v['title'], 0, 14) . ".." ;
			}
		}

		//tongzhigonggao
		$data['jygy'] = $this -> news_model -> getListByCId(11,4);
		foreach($data['jygy'] as $k => $v){
			$data['jygy'][$k]['add_time'] = date('Y-m-d', $v['add_time']);
			if(mb_strlen($v['title']) > 14){
				$data['jygy'][$k]['title'] = mb_substr($v['title'], 0, 14) . ".." ;
			}
		}

		// var_dump($data['tzgg']);

		$firstJjrd = $this -> news_model -> topNews(0, 1, 'jjrd', '1');
		$bellowJjrd = $this -> news_model -> topNews(0, 5, 'jjrd', '0');

		 // var_dump($firstJjrd);
		 $data['firstJjrd'] = $firstJjrd[0];
		 $data['bellowJjrd'] = $bellowJjrd;



		// var_dump($data['shrd']);
		//slide
		$data['slide'] = $this -> config_model -> getSlide();

		// var_dump($data['slide']);
		// var_dump($data['slide']);
		//pic news
		$picnews = $this -> news_model -> fgetByCId(8,3);
		$picnewsArr = array();
		foreach ($picnews as $key => $value) {
			$photoes = json_decode($value['content']);
			if(count($photoes) > 0) {
				$picnewsArr[] = array('id' => $value['news_id']
									,'src' => $photoes[0] -> src,
									'title' => $value['title']);
			}

		}
		$data['picnews'] = $picnewsArr;
		foreach ($data['picnews'] as $key => $value) {
			if(mb_strlen($value['title']) > 16){
				$data['picnews'][$key]['title'] = mb_substr($value['title'], 0, 16) . "..";
			}
		}



		//校园写意
		$data["xyxy"] = $this->news_model->fgetByCId(12, 3);
		$xyxyArr = array();
		foreach ($data["xyxy"] as $key => $value) {
			$photoes = json_decode($value['content']);
			if(count($photoes) > 0) {
				$xyxyArr[] = array('id' => $value['news_id']
									,'src' => $photoes[0] -> src,
									'title' => $value['title']);
			}
		}

		$data["xyxy"] = $xyxyArr;

		//get the guanyingjiaoyuan
		$data['pics']['img'] = array();
		$data['pics']['mimg'] = array();
		$pics = $this -> news_model -> fgetByCId(7, 3);
		foreach ($pics as $key => $value) {
			if (isset($value['img']) && !empty($value['img'])) {
				foreach ($value['img'] as $key1 => $value1) {
					$data['pics']['img'][] = $value1;
				}
				foreach ($value['mimg'] as $key2 => $value2) {
					$data['pics']['mimg'][] = $value2;
				}
			}
		}

		//光影交院处理
		$gyjy = $this -> news_model -> getListByCId(7, 4);
		foreach ($gyjy as $key => $value) {
			$gyjy[$key]['photoes'] = json_decode($value['content']);
		}



		$data['gyjy'] = $gyjy;
		//媒体交院处理
		$data['mtjy'] = $this -> news_model -> getListByCId(2, 5);

		foreach ($data['mtjy'] as $key => $value) {
			if(mb_strlen($data['mtjy'][$key]['title']) > 15){
				$data['mtjy'][$key]['title']  = mb_substr($value['title'], 0, 15) . "..";
			}
		}

		//视频展播处理
		$data['spzb'] = $this -> news_model -> getListByCId(6, 3);

		//微电台
		$data["wdt"] = $this->news_model->getListByCId(13, 3);



		$this -> load -> view('front/xww/index_view', array('data' => $data));
	}


	//v2 首页控制器
	public function new_index() {
		//bellow desktop handle
		$view_data = array();

		//导航栏数据
		$nav = $this->nav_model->get_front_navs();

		//幻灯片数据
		$sliders = $this->config_model->getSlide();

		//学院新闻，置顶数据
		$top_college_news = $this->article_model->get_top(INDEX_CID_COLLEGE_NEWS, 1);
		if(is_array($top_college_news) && count($top_college_news) > 0) {
			$top_college_news = $top_college_news[0];
		}else{
			$top_college_news = NULL;
		}

		//学院新闻
		$college_news = $this->article_model->get_by_cid(INDEX_CID_COLLEGE_NEWS, 5);

		//系部动态，置顶数据
		$top_depart_news = $this->article_model->get_top(INDEX_CID_DEPART_NEWS, 1);
		if(is_array($top_depart_news) && count($top_depart_news) > 0) {
			$top_depart_news = $top_depart_news[0];
		}else{
			$top_depart_news = NULL;
		}

		$depart_news = $this->article_model->get_by_cid(INDEX_CID_DEPART_NEWS, 5);


		$view_data['nav'] = $nav;
		$view_data['sliders'] = $sliders;
		$view_data['top_college_news'] = $top_college_news;
		$view_data['college_news']	   = $college_news;
		$view_data['top_depart_news'] = $top_depart_news;
		$view_data['depart_news'] = $depart_news;
		$this->load->view('default/index_view', $view_data);
	}

	//友情链接页面
	public function friendList(){
		$head['basepath'] = 'xww/third_party/floatpic/';
		$head['js'] = array(
			'js/jquery-1.9.1.min.js'
			);
		$this -> loadHeader(array('head' => $head));

		$recentList = $this -> news_crawler_model -> get(5, 0, 
			array('category_id' => 1,
					'is_top <>' => 2));
		
		$data['recentList'] = $recentList;

		$this -> load -> view('friendlink/browse_view', array('data' => $data));

		$this -> loadFooter();
	}

	//新页面
	public function newIndex(){
		
		//栏目
		$lmList = $this -> lm_model -> getList(9);
		foreach ($lmList as $key => $value) {
			if($value['cid'] != 0){
				$lmList[$key]['link_src'] = site_url($value['link_src']);
			}
		}
		if(count($lmList) == 0){
			$lmList = array();
		}
		$data['lmList'] = $lmList;

		//幻灯片
		$slider = $this -> config_model -> getSlideNew(6);
		$data['slider'] = $slider;

		//学院新闻
		$xyxw = $this -> news_crawler_model -> get(7, 0, 
			array('category_id' => 1));

		$data['xyxw'] = $xyxw;

		//系部动态
		$xbdt = $this -> news_crawler_model -> get(4, 0, 
			array('category_id' => 3));
		$data['xbdt'] = $xbdt;

		//get jjrd first


		//聚焦热点
		$jjrd = $this -> news_model -> getByPageByAlias(0, 4, 'jjrd');
		$data['jjrd'] = $jjrd;

		//媒体交院
		$mtjy = $this -> news_model -> getByPageByAlias(0, 3, 'mtjy');
		$data['mtjy'] = $mtjy;

		//视频展播
		$data['spzb'] = $this -> news_model -> getListByCId(6, 3);
		// var_dump($data['spzb']);
		// 图片新闻
		$data['tpxw'] = $this -> news_model -> getListByCId(8, 4);
		foreach ($data['tpxw'] as $key => $value) {
			$data['tpxw'][$key]['content'] = json_decode($value['content'], true);
		}

		$this -> load -> view('front2/index_view', array('data' => $data));
	}



	//mobile index get more index
	public function load_more_news() {
		$limit = $this->input->get('limit', TRUE);
		$offset = $this->input->get('offset', TRUE);

		if(empty($limit) || ! is_numeric($limit)) {
			$limit = 10;
		}else{
			$limit = intval($limit);
		}


		if(empty($offset) || ! is_numeric($limit)) {
			$offset = 0;
		}else{
			$offset = intval($offset);
		}

		$cond = array(
				'is_top'	=> FALSE,
			);
		$news = $this->news_crawler_model->get_xyxw_news_mobile($limit, $offset, $cond);

		$return_str = '';

		if(empty($news)) {
			echo '';
			return;
		}
		foreach($news as &$v) {
			$return_str .= '<dl><dt class="artitle_author_date"><div class="summer-index-cat">';
			$return_str .= $v['category_name'] . '</div><div class="summer-index-date">';
			$return_str .= $v['create_date'] . '</div></dt>';
			if( ! empty($v['cover_img'])) {
				$return_str .= '<dd class="m"><a href="'.site_url('m/archive/'.$v['id']).'">';
				$return_str .= '<img src="'.resource_url($v['cover_img']).'" alt="'.$v['title'].'"></a></dd>';
			}
			$return_str .= '<dt class="zjj_title"><a href="'.site_url('m/archive/'.$v['id']).'">'.$v['title'].'</a></dt>';
			$return_str .= '<dd class="cr_summary">'.$v['summary'].'</dd>';
			$return_str .= '<dd class="summer-index-tail"><span class="summer-index-like">'
						.$v['approve_times'].
				            '</span><span class="summer-index-hits">'.$v['hits'].'</span></dd></dl>';
		}

		echo $return_str;
	}


	//移动端，首页
	public function m_index() {
		// $this->nav_model->create_test();
		$navs = $this->nav_model->get_front_navs(1);
		$sliders = $this->config_model->getSlide();

		// var_dump($sliders);

		$cond = array(
				'is_top'	=> FALSE,
			);
		$xyxw_news = $this->news_crawler_model->get_xyxw_news_mobile(10, 0, $cond);

		// $a = $xyxw_news[0]['content'];
		// $a = strip_tags($a);
		// $a = preg_replace('/s/', '', $a);
		// $a = mb_substr($a, 0, 40);
		// var_dump($a);

		$view_data = array(
			'navs'		=> $navs,
			'sliders'	=> $sliders,
			'xyxw_news'	=> $xyxw_news,
			);
		$this->load->view('mobile/welcome_view', $view_data);
	}


	//移动端，文章页面
	public function m_archive() {
		// $this->output->enable_profiler(TRUE);
		$id = $this->uri->rsegment(3);
		$id = addslashes($id);
		$article = $this->news_crawler_model->get_by_id($id);

		if( ! $article) {
			show_404();
			return ;
		}

		$navs = $this->nav_model->get_front_navs(1);

		$view_data = array(
			'navs'		=> $navs,
			'article'	=> $article,
			);

		$this->load->view('mobile/article_archive_view.php', $view_data);
	}

	//学院新闻桌面
	public function collegenews() {
		if($this->agent->is_mobile() === TRUE) {
			redirect(site_url('m/collegenews'));
			return ;
		}

		echo '学院新闻桌面';
	}

	//学院新闻移动端
	public function m_collegenews() {
		if($this->agent->is_mobile() === FALSE) {
			redirect(site_url('collegenews'));
			return ;
		}

		echo '桌面新闻移动端';
	}

	//移动端未开放页面
	public function m_noopen() {
		$navs = $this->nav_model->get_front_navs(1);
		$view_data = array(
			'navs' => $navs,
			);
		$this->load->view('mobile/noopen_view.php', $view_data);
	}
}
