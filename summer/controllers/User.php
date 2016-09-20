<?php

defined('APPPATH') OR exit('forbbiden to access');

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
		$this->user_model->verify();
		if(! $this->user_model->is_super()) {
			show_error('你的权限不够');
		}
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
		$view_data['module_name'] = $this->user_config['module_name']['create'];
		$view_data['post_url'] = site_url('c=user&m=create');

		if($_POST) {
			if($this->_check_form()) {
				$this->user_model->create();
				set_flashalert($this->lang->line('user_create_success'));
				redirect(site_url('c=user&m=index'));
				return ;
			}
		}

		$form_generate_config = $this->user_config['form_generate'];
		$view_data['form_generate'] = $this->form_generate->display($form_generate_config);
		$this->_load_view('default/user_form_view', $view_data);
	}

	//修改用户
	public function edit() {
		$view_data['module_name'] = $this->user_config['module_name']['edit'];
		$view_data['post_url'] = site_url('c=user&m=edit');

		if( ! empty($_POST)) {
			$this->form_validation->set_rules(
				array(
							array(
								'field'	=> 'password1',
								'label' => '密码',
								'rules'	=> 'required|min_length[6]|max_length[16]|alpha_numeric',
								),
							array(
								'field'	=> 'password2',
								'label' => '重复密码',
								'rules'	=> 'matches[password1]',
								),
							array(
								'field'	=> 'id',
								'label' => '用户ID',
								'rules'	=> 'required|numeric',
								),
							)
				);

			if($this->form_validation->run()) {
				$password1 = $this->input->post('password1');
				$user_id = $this->input->post('id');
				$user = $this->user_model->get_by_id(intval($user_id));
				if(empty($user)) {
					show_error('修改用户不存在');
				}

				$password = $this->user_model->create_password($password1, $user['account']);

				$update_user = array(
					'password' => $password,
					);

				$this->user_model->update_by_id($update_user, $user_id);
				set_flashalert('修改修改用户成功');
				redirect(site_url('c=user&m=index'));
				return ;
			}
		}

		$user_id = $this->input->get('id');
		if(! empty($user_id)) {
			$user = $this->user_model->get_by_id($user_id);
			if(empty($user)) {
				show_error('修改用户不存在');
			}
		}else{
			$user = array();
		}
		$form_generate_config = $this->user_config['form_generate'];
		$view_data['form_generate'] = $this->form_generate->display($form_generate_config, $user);
		$this->_load_view('default/user_form_view', $view_data);
	}

	public function del() {
		$user_id = $this->input->get('id');
		if(empty($user_id) && ! is_numeric($user_id)) {
			show_error('用户ID错误');
		}

		$user = $this->user_model->get_by_id(intval($user_id));
		if(empty($user)) {
			show_error('删除用户不存在');
		}

		$this->user_model->del_by_id($user['id']);
		set_flashalert('删除用户【' . $user['account'] . '】成功！' );
		redirect(site_url('c=user&m=index'));
		return ;
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

				$this->session->set_userdata('user', $user);
				redirect(site_url('c=main'));
			}
		}
		$this->load->view('default/login_view');
	}

	public function logout() {
		session_destroy();
		$referer = $this->input->server('HTTP_REFERER');
		if(!empty($referer)) {
			redirect(site_url('c=user&m=login&referer=' . urlencode($referer)));
		}else{
			redirect(site_url('c=user&m=login'));
		}
	}

	public function _check_form() {
		$user_config = $this->config->item('user_config');
		$form_generate = $user_config['form_generate'];
		foreach($form_generate as $k=>$v) {
			if(isset($v['rules']) && isset($v['label'])) {
				$this->form_validation->set_rules($k, $v['label'], $v['rules']);
			}
		}

		return $this->form_validation->run();
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
}