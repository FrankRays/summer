<?php

defined("APPPATH") or exit("no access");

class Nav extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model("nav_model");
        $this->load->model('user_model');
    }


    public function admin()
    {
        $this->user_model->is_admin();
        $view_data['module_name'] = '导航栏列表';
        $view_data['module_path'] = get_module_path(array(
            array('导航栏列表', site_url('c=nav&m=admin')),
            ));

        $table_builder_config = array(
            "controller_name"       => "nav",
            );
        $this->load->library("table_builder", $table_builder_config);
        $this->table_builder->display();

        $view_data['page'] = $this->nav_model->get_page();
        $view_data['js_source_code'] = $this->js_builder->get_js_source_code();

        $this->_load_view('default/nav/admin_view', $view_data);
    }

    public function create()
    {
        $this->user_model->is_admin();

        $this->config->load('s/form_config');
        $form_config = $this->config->item('nav_form');
        
        $view_data['module_name'] = '添加导航栏';
        $view_data['module_path'] = get_module_path(array(
            array('导航栏列表', site_url('c=nav&m=admin')),
            array('添加导航栏', ''),
            ));

        if (! empty($_POST)) {
            var_dump($_POST);
            if ($this->nav_model->save()) {
                set_flashalert("创建导航栏成功");
            } else {
                set_flashalert("创建导航栏失败");
            }

            redirect(site_url("c=nav&m=admin"));
        }

        $this->load->model('article_cat_model');
        $form_config['fields']['article_cid']['options'] = $this->article_cat_model->get_pair();
        $form_config['fields']['cid']['options'] = $this->nav_model->get_cat_pair();

        $this->load->library('form_generate', $form_config);
        $view_data['form_html'] = $this->form_generate->create_form();

        $this->_load_view('default/nav/form_view', $view_data);
    }

    public function edit()
    {
        $this->user_model->is_admin();
        $view_data['module_name'] = "更新导航栏";
        $view_data['module_path'] = get_module_path(array(
            array('导航栏列表', site_url('c=nav&m=admin')),
            array('更新导航栏', ''),
            ));

        if (! empty($_POST)) {
            if ($this->nav_model->save() !== false) {
                set_flashalert("保存成功");
                redirect(site_url("c=nav&m=admin"));
            }
        }

        $id = $this->input->get_post('id', true);
        if (is_null($id) or ! is_numeric($id)) {
            show_404();
        }

        $nav = $this->nav_model->get_by_id($id);
        if (is_null($nav)) {
            show_404();
        }

        if (empty($_POST)) {
            $_POST = $nav;
        }

        $this->config->load('s/form_config');
        $form_config = $this->config->item('nav_form');
        $form_config['action'] = 'c=nav&m=edit';
        $this->load->model('article_cat_model');
        $form_config['fields']['article_cid']['options'] = $this->article_cat_model->get_pair();
        $form_config['fields']['cid']['options'] = $this->nav_model->get_cat_pair();

        $this->load->library('form_generate', $form_config);
        $this->form_generate->set_value('id', $nav['id']);
        $view_data['form_html'] = $this->form_generate->create_form();

        $this->_load_view("default/nav/form_view", $view_data);
    }

    public function del()
    {
        $this->user_model->is_admin();
        if ($this->nav_model->del()) {
            set_flashalert("Delete successfully");
        } else {
            set_flashalert("Delete failed");
        }

        redirect(site_url("c=nav&m=admin"));
    }
}
