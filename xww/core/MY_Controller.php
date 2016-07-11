<?php if(! defined('BASEPATH')) exit('No direct script access allowd');

class MY_Controller extends CI_Controller{
	
	public function __construct(){	
		parent::__construct();

		$this -> load -> helper("url");
		$this -> load -> helper('cookie');
		$this -> load -> library('session');
		$this -> load -> library('yerror');
		$this -> load -> model('lm_model');
		$this -> load -> model('news_category_model');
		$this -> load -> model('friendlink_model');

	}

	//游客做cookie标记
	// protected function _get_user_id() {
	// 	$visitor_id
	// }

	/*
	*@name loadHeader
	*@desc load the head of the index page 
	*@access public 
	*@ee
	*/
	public function loadHeader($data = ''){


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
		// var_dump($data['lmList']);
		// var_dump($lmList);
		//取出栏目数据
		
		$this -> load -> view('front/ft_top_view', $data);

	}

	/*
	*@name loadFooter
	*@desc load the head of the index page 
	*@access public 
	*@ee
	*/
	public function loadFooter($data = ''){
		//取得友情链接
		//$data['friend_link'] = $this -> friendlink_model -> getList(12);

		$this -> load -> view('front/ft_foot_view');

	}		


	/*取得需要显示栏目的数据*/
	public function _lm($num = '', $is_nav= ''){
		$lm_list = $this -> lm_model -> getList($num, $is_nav);
		if(!is_array($lm_list)) return;
		return $lm_list;

	}
	/*取得新闻列表*/
	public function _newsList($alias='', $row='10'){
		$news_list = $this -> news_model -> getListByCId($alias ,$row );
		$news_list_length = count($news_list);
		for($i = 0; $i < $news_list_length; $i++){
			if(mb_strlen($news_list[$i]['title'],'UTF8') > 25){
				$news_list[$i]['title'] = mb_substr($news_list[$i]['title'], 0,25, 'utf8').'......';
			}
		}
		if(empty($news_list)) return;
		return $news_list;
	}
	/*取得通知公告栏目数据*/
	public function _lm_tzgg($alias, $is_nav){
		$lm_tzgg = $this -> lm_model -> getByAlias($alias, $is_nav);
		if(!is_array($lm_tzgg)) return;
		return $lm_tzgg;
	}

	/*取得通知列表*/
	public function _tz(){
		$hidden_lm_list = $this ->  _lm('20', '0');
		$hidden_lm_list_length = count($hidden_lm_list);
		for($h = 0; $h < $hidden_lm_list_length; $h++){
			if($hidden_lm_list[$h]['alias'] == 'tzgg'){
				$tz['tzgg_link'] = $hidden_lm_list[$h]['link_src'];
			}else{
				$tz['tzgg_link'] = 'http://rwx.svtcc.edu.cn/index.php/rw';
			}

		}
		$tz['tz_list'] = $this -> _newsList('tzgg','8');
		return $tz;
	}

	/*初始化分页配置*/
	public function _pagination($kind, $total_rows, $per_page, $lm_alias){
		$this->load->library('pagination');  
	    // 导入分页类
	    $config = array(
				'base_url'      => site_url().'/'.$kind.'/li/'.$lm_alias,  // 导入分页类的url
				'total_rows'    => $total_rows,  // 计算总记录数
				'per_page'      => $per_page,  // 每页显示的记录数  
				'full_tag_open' => '<div class="pagin"> <ul class="paginList">',
				'full_tag_close'=> ' </ul> </div> ',
				'prev_tag_open' => '<li class="paginItem">',
				'prev_tag_close'=> '</li>',
				'next_tag_open' => '<li class="paginItem">',
				'next_tag_close'=> '</li>',
				'num_tag_open'  => '<li class="paginItem">',
				'num_tag_close' => '</li>',
				'cur_tag_open'  => '<li class="paginItem current"> <a>',
				'cur_tag_close' => '</a></li>',
				'prev_link'     => '<span class="pagepre"></span>',
				'next_link'     => '<span class="pagenxt"></span>',
				'last_link'     => '末页',
				'first_link'    => '首页',
				'last_tag_open' => '<li class="paginItem">',
				'last_tag_close'=> '</li>',
				'first_tag_open'=> '<li class="paginItem">',
				'first_tag_close'=>'</li>',
				'uri_segment'   => 4,        //设置url上第几段用于传递分页器的偏移量
				'num_links'     => 4,
	    	);
		$this->pagination->initialize($config);        // 初始化分页类
	}

	/**
 	*the init pagiation by ykjver
 	*@param $base_url int the base url of the pagination
 	*@param $total_rows the total rows of the data
 	*@param $per_page the number of the per page
	**/
	public function _pagination2($base_url, $total_rows, $per_page){
		$this->load->library('pagination');  
	    // 导入分页类
	    $config = array(
				'base_url'      => $base_url,  // 导入分页类的url
				'total_rows'    => $total_rows,  // 计算总记录数
				'per_page'      => $per_page,  // 每页显示的记录数  
				'full_tag_open' => '<div class="pagin"> <ul class="paginList">',
				'full_tag_close'=> ' </ul> </div> ',
				'prev_tag_open' => '<li class="paginItem">',
				'prev_tag_close'=> '</li>',
				'next_tag_open' => '<li class="paginItem">',
				'next_tag_close'=> '</li>',
				'num_tag_open'  => '<li class="paginItem">',
				'num_tag_close' => '</li>',
				'cur_tag_open'  => '<li class="paginItem current"> <a>',
				'cur_tag_close' => '</a></li>',
				'prev_link'     => '<span class="pagepre"></span>',
				'next_link'     => '<span class="pagenxt"></span>',
				'last_link'     => '末页',
				'first_link'    => '首页',
				'last_tag_open' => '<li class="paginItem">',
				'last_tag_close'=> '</li>',
				'first_tag_open'=> '<li class="paginItem">',
				'first_tag_close'=>'</li>',
				'uri_segment'   => 4,        //设置url上第几段用于传递分页器的偏移量
				'num_links'     => 4,
	    	);
		$this -> pagination -> initialize($config);        // 初始化分页类
		return $this -> pagination -> create_links();
	}


	/**
	*首页根据别名取得新闻模块数据
	*@param 新闻分类别名
	*@param 获取数据条目数
	*@return array['categoryList']  该分类的信息
	*@return array['newsList']      新闻列表数据
	**/
	public function _getByAlias($alias, $num = 5){
		$data['categoryList'] = $this -> news_category_model -> getByAlias($alias);

		//!!!!!!!!!!!!!!!!!!!!!这里有重定向循环的风险
		if(empty($data['categoryList'])){
			header('Location:'.site_url());
			exit();
		}
		$data['newsList'] = $this -> news_model -> getListByCId($data['categoryList']['id'], $num);
		return $data;
	}

}