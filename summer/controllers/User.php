<?php defined('APPPATH') OR exit('forbbiden to access');

class User extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('user_model');

		//加载类库
		$this->load->library('form_generate');

		//加载用户配置文件
		$a = $this->config->load('s/user_config');
		$this->user_config = $this->config->item('user_config');

	}

	public function admin() {
		$this->user_model->is_admin();
		$this->index();
	}


	// list page of user
	public function index() {
		get_sidebar();
		$this->user_model->is_super();
		$view_data['module_name'] = $view_data['module_desc'] = $this->user_config['module_name']['index'];

		$offset = 0;
		if(isset($_POST['offset']) && is_numeric($_POST['offset'])) {
			$offset = intval($_POST['offset']);
		}

		$page_config = $this->config->item('page_config');
		$page = $this->user_model->get_page($page_config['per_page'], $offset, array());

		$page_config['base_url'] = $this->_get_page_base_url();
		$page_config['total_rows'] = $page['total_rows'];
		$this->pagination->initialize($page_config);

		$view_data['users'] = $page['data_list'];
		$view_data['total_rows'] = $page['total_rows'];
		$view_data['pagination'] = $this->pagination->create_links();
		$this->_load_view('default/user_browser_view', $view_data);
	}


	//添加用户
	public function create() {
		$this->user_model->is_admin();
		$this->user_model->is_super();
		$this->load->model('article_cat_model');

		$view_data['module_name'] = $this->user_config['module_name']['create'];
		$view_data['post_url'] = site_url('c=user&m=create');

		if($_POST) {
			if($this->user_model->create()) {
				set_flashalert($this->lang->line('user_create_success'));
				redirect(site_url('c=user&m=index'));
			}
		}

		$this->config->load('s/form_config');
		$user_form_config = $this->config->item('user_form');
		$user_form_config['action'] = 'c=user&m=create';
		$user_form_config['fields']['article_cate_access']['options'] = $this->article_cat_model->get_pair();

		$this->load->library('form_generate');
		$this->form_generate->initialize($user_form_config);
		$view_data['form_html'] = $this->form_generate->create_form();

		$this->_load_view('default/user_form_view', $view_data);
	}

	//修改用户
	public function edit() {
		$this->user_model->is_admin();
		$this->user_model->is_super();

		$this->config->load('s/form_config');
		$this->load->library('form_generate');
		$this->load->model('article_cat_model');

		$view_data['module_name'] = $this->user_config['module_name']['edit'];
		$view_data['post_url'] = site_url('c=user&m=edit');

		if( ! empty($_POST)) {
			if($this->user_model->update_user()) {
				set_flashalert('修改用户成功');
				redirect(site_url('c=user&m=index'));
			}
		}

		$user_id = $this->input->get_post('id');
		if(! empty($user_id)) {
			$user = $this->user_model->get_by_id($user_id);
			if(empty($user)) {
				show_404();
			} else {
				unset($user['password']);
				$user['article_cate_access'] = json_decode($user['article_cate_access'], TRUE);
				$_POST = $user;
			}
		}else{
			show_404();
		}

		$user_form_config = $this->config->item('user_form');
		unset($user_form_config['fields']['repassword']);
		unset($user_form_config['fields']['password']);
		$user_form_config['fields']['account']['attr'] = array('disabled'=>'disabled');
		$user_form_config['action'] = 'c=user&m=edit';
		$user_form_config['fields']['article_cate_access']['options'] = $this->article_cat_model->get_pair();
		$this->form_generate->initialize($user_form_config);
		$view_data['form_html'] = $this->form_generate->create_form();

		$this->_load_view('default/user_form_view', $view_data);
	}

	public function lock_user() {
		$this->user_model->is_admin();
		$this->user_model->is_super();
		$this->output->set_content_type('application/javascript');
		if($_POST) {
			$this->user_model->lock_user();
			set_flashalert('锁定用户成功');
			echo json_encode(array('status'=>300, 'message'=>site_url('c=user&m=index')));
			return ;
		}

		echo json_encode(array('status'=>200, 'message'=>'锁定用户失败'));
	}

	public function unlock_user() {
		$this->user_model->is_admin();
		$this->user_model->is_super();
		$this->output->set_content_type('application/javascript');

		if($_POST) {
			$this->user_model->unlock_user();
			echo json_encode(array('status'=>300, 'message'=>site_url('c=user&m=index')));
			return ;
		}

		echo json_encode(array('status'=>200, 'message'=>'解锁用户失败'));
	}

	public function del() {
		$user_id = $this->input->get('id');

		if($_POST) {
			if($this->user_model->delete_user()) {
				echo json_encode(array('status'=>300, 'message'=>site_url('c=user&m=index')));
			}
			return ;
		}

		echo json_encode(array('status'=>200, 'message'=>'删除用户失败'));
	}

	//管理员登录
	public function login() {
		$server = $this->input->server(null);
		if(!empty($server)) {
			$this->form_validation->set_rules(
				array(
					array(
						'field'	=>	'account',
						'label'	=>	'账号',
						'rules'	=>	'required|alpha_numeric',
						),
					array(
						'field'	=>	'password',
						'label'	=>	'密码',
						'rules'	=> 	'required',
						),
					)
				);

			if($this->form_validation->run()) {
				$account = $this->input->post('account');
				$password = $this->input->post('password');

				$user = $this->user_model->get_by_account($account);

				if(empty($user)) {
					$this->form_validation->set_error_array(array('用户不存在'));
					$this->_load_view('default/login_view');
					return ;
				}

				$locked_time = strtotime($user['locked']);
				if($locked_time > time()) {
					$this->form_validation->set_error_array(array('该用户被锁定,' . $user['locked'] . '以后可以再次登陆'));
					$this->_load_view('default/login_view');
					return ;
				}

				if($user['fails'] > 5) {
					$locked_time = date(TIME_FORMAT, time() + 3600);
					$this->form_validation->set_error_array(array('密码错误次数过多，在'.$locked_time.'后尝试登陆'));
					$update_user = array(
						'fails'			=> 0,
						'locked'	=> $locked_time,
						);
					$this->user_model->update_by_id($update_user, $user['id']);
					$this->_load_view('default/login_view');
					return ;
				}


				$login_success = $this->user_model->login($account, $password);

				if( empty($login_success)) {
					$update_user = array(
						'fails'		=> $user['fails'] + 1,
						);
					$this->user_model->update_by_id($update_user, $user['id']);
					$this->form_validation->set_error_array(array('密码错误'));
					$this->_load_view('default/login_view');
					return;
				}

				if(! empty($user['article_cate_access'])) {
					$user['article_cate_access'] = json_decode($user['article_cate_access'], TRUE);
				}
				$this->session->set_userdata('user', $user);
				redirect(site_url('c=main'));
			}
		}
		$this->load->view('default/login_view');
	}

	public function logout() {
		$this->user_model->is_admin();
		$this->user_model->logout();
	}

	public function _get_page_base_url() {
		$base_url_arr = array();
		foreach($this->input->get() as $k=>$v) {
			if($k != 'offset') {
				$base_url_arr[] = $k . '=' . $v;
			}
		}

		return site_url(implode($base_url_arr, '&'));
	}


	public function change_password() {
		$this->user_model->is_admin();
		$view_data['module_name'] = '修改密码';
		$view_data['module_desc'] = '修改密码';

		if($_POST) {
			if($this->user_model->change_password() == TRUE) {
				$this->user_model->logout();
				set_flashalert('修改密码成功');
				redirect(site_url('c=user&m=login'));
			}
		}

		$this->config->load('s/form_config');
		$this->load->library('form_generate');
		$change_password_form_config = $this->config->item('change_password_form');
		$this->form_generate->initialize($change_password_form_config);


		$view_data['form_html'] = $this->form_generate->create_form();
		$this->_load_view('default/user_form_view', $view_data);
	}

	public function change_my_password() {
		$account = 'yangzihao';
		$password = '123456';

		$update_user = array(
			'password'	=> $this->user_model->create_password($password, $account),
			);

		$this->db->where('account', $account)->update(TABLE_USER, $update_user);
	}

	public function set_default_password() {
		$this->user_model->is_admin();
		$this->user_model->is_super();

		if($_POST) {
			if($this->user_model->set_default_password()) {
				echo json_encode(array('status'=>300, 'message'=>site_url('c=user&m=index')));
			}
			return ;
		}

		echo json_encode(array('status'=>200, 'message'=>'解锁用户失败'));
	}

	public function user_info() {
		$this->user_model->is_admin();
		$view_data['module_name'] = '用户信息';
		$view_data['module_desc'] = '用户信息';

		$view_data['user'] = $this->user_model->get_cur_user();

		$this->_load_view('default/user/user_info_view', $view_data);
	}

	public function role_brower() {
		$this->user_model->is_admin_redirect();


	}

	public function test() {
		$this->load->library('rbac');
		$this->load->model('role_model');
		$this->role_model->create_child(14, array('name'=>'ke'));
	}

}