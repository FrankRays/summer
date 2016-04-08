<?php defined('BASEPATH') || exit('no direct script access allowed'); 

class Rw extends Ykj_controller{

	/*构造方法*/
	public function __construct(){
		parent::__construct();

		$this -> load -> model('news_model');
		$this -> load -> model('news_category_model');
		$this -> load -> model('student_model');
		$this -> load -> model('friendlink_model');
		$this -> load -> model('lm_model');
		$this -> load -> model('file_model');
		$this -> load -> model('config_model');	
		$this -> load -> model('news_crawler_model');
		$this -> load -> library('Crawler');
	}

	/*前台主控制器*/
	public function index(){

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
		// $xyxw = $this -> news_model -> getIndexModel(9, 3);
		//var_dump($xyxw);
		$data['xyxw'] = $xyxwNew;
		$data['xyxwFirst'] = $this -> news_crawler_model -> get(4, 0, 
			array('category_id' => 1,
					'is_top' => 2));
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
		
		$this -> load -> view('front/xww/index_view', array('data' => $data));
	}



	public function test(){
		$url = "http://www.svtcc.edu.cn/newslist.jsp?cate=1";
		$result = $this -> crawler -> doCrawler($url);
		$this -> news_crawler_model -> update($result);

		$url = "http://www.svtcc.edu.cn/newslist.jsp?cate=3";
		$result = $this -> crawler -> doCrawler($url);
		$this -> news_crawler_model -> update($result);
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
}
