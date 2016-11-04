<?php defined('BASEPATH') || exit('no direct script access allowed');


//v2 幻灯片控制器
class Slider extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('slider_model');
        $this->load->model('file_model');
        $this->load->model('user_model');
    }

    public function index()
    {
        $this->admin();
    }

    public function admin()
    {
        $this->user_model->is_admin();
        $view_data['module_name'] = '幻灯片列表';
        $view_data['bread_path'] = get_module_path(array(
            array('幻灯片列表', site_url('c=slider&m=admin')),
            ));

        $offset = $this->input->get('offset');
        if (empty($offset) or ! is_numeric($offset)) {
            $offset = 0;
        } else {
            $offset = intval($offset);
        }

        $page_config = $this->config->item('page_config');

        $page = $this->slider_model->get_page($page_config['per_page'], $offset);

        $page_config['base_url'] = deal_page_base_url();
        $page_config['total_rows'] = $page['total_rows'];
        $this->pagination->initialize($page_config);

        $page_links = $this->pagination->create_links();
        $view_data['data_list'] = $page['data_list'];
        $view_data['total_rows'] = $page['total_rows'];
        $view_data['page_links'] = $page_links;
        $this->_load_view('default/slider_browse_view.php', $view_data);
    }


    public function create()
    {
        $this->user_model->is_admin();
        $view_data['module_name'] = '幻灯片添加';
        $view_data['bread_path'] = get_module_path(array(
            array('幻灯片列表', site_url('c=slider&m=admin')),
            array('添加幻灯片', '#')));
        $view_data['post_url'] = site_url('c=slider&m=create');

        if ($_POST) {
            //valida form
           
            if (! $this->_check_form()) {
                $this->_load_view('default/slider_form_view', $view_data);
                return ;
            }
           
            //insert data
            $insert_data = array(
                'title'     => stripslashes($this->input->post('title', true)),
                'href'      => $this->input->post('href', true),
                'img_path'  => $this->input->post('img_path', true),
                'create_time'=>date(TIME_FORMAT),
                'cat_id'    => 1,
                'is_delete' => '0',
            );

            $this->db->insert(TABLE_SLIDER, $insert_data);
            if (! $this->db->insert_id()) {
                show_error('添加失败，请重新添加');
            }

            set_flash_msg('添加【'.$insert_data['title'].'】幻灯片成功', 'success');
            redirect(site_url('c=slider&m=admin'));
        }
        $this->_load_view('default/slider_form_view', $view_data);
    }


    public function edit()
    {
        $this->user_model->is_admin();
        $view_data['module_name'] = '幻灯片编辑';
        $view_data['bread_path'] = get_module_path(array(
            array('幻灯片列表', site_url('c=slider&m=admin')),
            array('编辑幻灯片', '#')));
        $view_data['post_url'] = site_url('c=slider&m=edit');


        $slider_id = $this->input->get_post('slider_id');
        if (empty($slider_id) or !is_numeric($slider_id)) {
            show_404();
        } else {
            $slider_id = intval($slider_id);
        }

        $where = array(
                'is_delete'         => '0',
                'id'            => $slider_id,
                );
        $slider = $this->db->from(TABLE_SLIDER)->where($where)->get()->row_array();
        if (empty($slider)) {
            show_404();
        }

        if ($_POST) {
            if ($this->_check_form()) {
                $img_path = $this->input->post('img_path', true);
                $title = $this->input->post('title', TURE);
                $href = $this->input->post('href', true);
                $update_data = array(
                    'title'=>$title,
                    'href'=>$href,
                    'img_path'=>$img_path,
                );

                $this->db->where('id', $slider_id)->update(TABLE_SLIDER, $update_data);
                set_flash_msg('修改幻灯片成功', 'success');
                redirect('c=slider&m=admin');
            }
        }
        $_POST = $slider;
        $this->_load_view('default/slider_form_view', $view_data);
    }

    private function _check_form()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '标题', 'required|max_length[64]|min_length[1]');
        $this->form_validation->set_rules('href', '链接', 'valid_url');
        $this->form_validation->set_rules('img_path', '图片', 'required');

        if ($this->form_validation->run()) {
            return true;
        } else {
            return false;
        }
    }

    public function del()
    {
        $slider_id = $this->input->get('slider_id');
        var_dump($slider_id);
        if (empty($slider_id) || ! is_numeric($slider_id)) {
            $slider_id = 0;
        } else {
            $slider_id = intval($slider_id);
        }


        $this->db->from(TABLE_SLIDER)->where(array('id'=>$slider_id))->delete();
        if ($this->db->affected_rows()) {
            set_flashalert('删除幻灯片成功');
        } else {
            set_flashalert('删除幻灯片失败');
        }

        redirect(site_url('c=slider&m=admin'));
    }

    public function delete()
    {
        sleep(1);
        if ($_POST) {
            set_ajax_header();
            $delete_ids = $this->input->post('delete_ids');
            $delete_ids_int = array();
            $delete_titles = array();
            if (is_array($delete_ids)) {
                foreach ($delete_ids as $id) {
                    if (is_numeric($id)) {
                        $id = intval($id);
                        $is_exist = $this->db->from(TABLE_SLIDER)->where('id', $id)->get()->row_array();
                        if (! empty($is_exist)) {
                            array_push($delete_titles, $is_exist['title']);
                            array_push($delete_ids_int, $id);
                        }
                    }
                }
            }

            if (count($delete_ids_int) > 0) {
                $this->db->from(TABLE_SLIDER)->where_in('id', $delete_ids_int)->delete();
                $success_msg = '删除幻灯片【'.implode(',', $delete_titles).'】成功';
                set_flash_msg($success_msg, 'success');
                echo json_msg($success_msg, 'success');
            } else {
                echo json_msg('删除幻灯片失败', 'error');
            }
        }
    }
}
