<?php if(! defined('BASEPATH')) exit('No direct script access allowd');

class MY_Controller extends CI_Controller{
	//默认模板传值
	protected $_data;
	//默认模板后缀
	protected $_tplext;
	//默认head模板
	protected $_header;
	//默认foot模板
	protected $_footer;

	//构造方法
	public function __construct(){	
		parent::__construct();

		//系统自动载入的模块，属于核心类
		//载入yconfig配置文件
		//$this -> config -> load('snowConfig/admin.php', TRUE);
		$this -> load -> helper("url");
		$this -> load -> helper('cookie');
		$this -> load -> library('session');
		$this->load->helper("form");
		$this -> load -> library('yerror');
		$this -> load -> model('lm_model');
		$this -> load -> model('news_category_model');
		$this -> load -> model('friendlink_model');
		$this -> load -> model('article_model');
		$this -> load -> model('user_model');
		$this -> load -> library('pagination');
		$this -> config -> load('snowConfig/admin', true);

		$this -> _data['head']['sitename'] = SITENAME;
		$this -> _data['head']['tplHeadCss'] = array();
		array_push($this -> _data['head']['tplHeadCss'], 
			base_url('source/AmazeUI-2.1.0/assets/css/amazeui.min.css'));
		$this -> _tplext = '.php';
		$this -> _header = 'v_01/common/head_view';
		$this -> _footer = 'v_01/common/foot_view';
		$this -> _sidebar = 'v_01/common/sidebar_view';
		$this -> _purehead = 'v_01/common/purehead_view';
		$this -> _purefoot = 'v_01/common/purefoot_view';
		$this -> _data['content'] = array();
		$this -> _data['foot'] = array();

		//开发模式下开启性能分析模式
		// if(ENVIRONMENT == 'development'){
		// 	$this -> output -> enable_profiler(TRUE);
		// }

		//分页配置文件
		$this->_paginationConfig = $this->config->item('paginationConfig', 'snowConfig/admin');
		session_start();
		$RTR =& load_class('Router', 'core');
		if($RTR->fetch_class() != "login"){
			 $this -> judgeLogin();
		}
	}

	public function judgeLogin($login = FALSE){
		$session_Clogin = $this -> session -> userdata('user');
		// $cookie_Clogin = $this -> input ->	cookie('user', TRUE);
		// var_dump($session_Clogin);
		// var_dump($session_Clogin);
			if(empty($session_Clogin) || empty($_SESSION['user'])){
				if($login == TRUE){
					return TRUE;
				}
				$msg = '你还没有登陆';
				$href = site_url('user/login/index');
				// var_dump($href);
				$this -> yerror -> showYAdminError($msg, $href);
				exit();
			}
	}

	//ajax页面view load 方法
	public function _pureview($tplPath){
		$this -> load -> view($this -> _purehead);
		$this -> load -> view($tplPath, $this -> _data['content']);
		$this -> load -> view($this -> _purefoot);
	}

	//封装CI框架的view load 方法
	public function _view($tplPath){
		$this -> load -> view($this -> _header, array('head' => $this -> _data['head']));
		if(isset($this -> _data['sidebar'])){
			$this -> load -> view($this -> _sidebar, array('sidebar' => $this -> _data['sidebar']));
		}else{
			$this -> load -> view($this -> _sidebar);
		}
		$this -> load -> view($tplPath, array('content' => $this -> _data['content']));
		$this -> load -> view($this -> _footer, array('foot' => $this -> _data['foot']));
	}

	/**
	 * load default admin template view
	 * @param  [type] $tplPath [description]
	 * @param  [type] $data    [description]
	 * @return [type]          [description]
	 */
	public function _loadView($tplPath, $data) {
		$head = isset($data["head"]) ? $data["head"] : array();
		$sidebar = isset($data["sidebar"]) ? $data["sidebar"] : array();
		$foot = isset($data["foot"]) ? $data["foot"] : array();
		$this->load->view($this->_header, $head);
		$this->load->view($this->_sidebar, $sidebar);
		$this->load->view($tplPath, $data);
		$this->load->view($this->_footer, $foot);
	}

	/*
	*@name loadHeader
	*@desc load the head of the index page 
	*@access public 
	*@ee
	*/
	public function loadHeader($data = ''){


		$lmList = $this -> lm_model -> getList(9);
		foreach ($lmList as $key => $value) {
			if(empty($value['link_src'])){
				$lmList[$key]['link_src'] = site_url('news/li/'.$value['cid']);
				$lmList[$key]['child'] = $this -> news_category_model -> getRecList($value['cid']);
			}else{
				if($value['link_src'] == 'site_url'){
					$lmList[$key]['link_src'] = site_url();
				}
			}
		}
		$data['lmList'] = $lmList;
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
	//获得分页链接html字符串
	public function _getPaginationStr($total){
		//载入配置文件
		//分页信息
		$getArr = $this->input->get();
		$getStr = '';
		$paginationConfig['base_url'] = site_url($getStr);
		$paginationConfig['total_rows'] = $total;
		//分页类载入
		$this->pagination->initialize($paginationConfig);
		return $this->pagination->create_links();
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

	public function yPotal(){

		//局域网内有问题 现在都可以使用
		// if( ! $this -> user_model -> getUserByToken()){
		// 	header('Location:'.site_url('d=user&c=login&m=index'));
		// }
	}

	public function ySignPotal(){
		// if( $this -> user_model -> getUserByToken()){
		// 	header('Location:'.site_url('d=article&c=y&m=index'));
		// }
	}
}