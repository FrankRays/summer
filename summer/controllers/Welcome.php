<?php defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('site_model');
        $this->load->model('article_model');
        $this->load->model('nav_model');
        $this->load->model('article_cat_model');
        $this->load->model('file_model');
        $this->load->model('slider_model');

        $this->load->library('user_agent');

        $this->load->vars('navs', $this->nav_model->get_list(1, 10, 0));
        $this->load->vars('title', config_item('site_name'));
    }

    public function index()
    {
        if ($this->agent->is_mobile()) {
            $this->m_index();
            return ;
        }
        $this->site_model->increase_site_hits();

        //get index page content
        $data_view['sliders']   = $this->slider_model->f_get_list(50, 0);
        $data_view['college_news_top']      = $this->article_model->get_top_list(1, 0, 2);
        $data_view['college_news']          = $this->article_model->get_front_list(5, 0, 2);
        $data_view['notice']                = $this->article_model->get_front_list(4, 0, 1);
        $data_view['departnotice_top']      = $this->article_model->get_top_list(1, 0, 3);
        $data_view['departnotice']          = $this->article_model->get_front_list(5, 0, 3);
        $data_view['focushot']              = $this->article_model->get_front_list(5, 0, 4);
        $data_view['read_top']              = $this->article_model->get_top_list(1, 0, 9);
        $data_view['read']                  = $this->article_model->get_front_list(5, 0, 9);
        $data_view['photo']                     = $this->article_model->get_front_list(3, 0, 5);
        $data_view['video']                     = $this->article_model->get_front_list(3, 0, 6);
        $data_view['reading']               = $this->article_model->get_front_list(3, 0, 10);
        $data_view['photolight']            = $this->article_model->get_front_list(4, 0, 8);
        $data_view['radio']                     = $this->article_model->get_front_list(3, 0, 11);
        //old index page exist
        $data_view['college_media']             = $this->article_model->get_front_list(4, 0, 7);

        foreach ($data_view['read'] as &$v) {
            if (mb_strlen($v['title']) >= 25) {
                $v['title'] = mb_substr($v['title'], 0, 25) . '...';
            }
        }

        $this->load->model('visitor_model');
        $this->visitor_model->record_visitor('index', 0);


        $this->load->view('front/welcome/old_index_view', $data_view);
    }

    private function check_love_article($article_id)
    {
        $this->load->model('user_model');
        $v_user_id = $this->user_model->get_v_user_id();
        if (empty($v_user_id)) {
            //empty user id to create a new user id
            $this->load->vars('isloved', false);
            return false;
        } else {
            //find if this user has love this article by v_userid
            $is_loved = $this->db->from(TABLE_ARTICLE_LOVE)->where(array('article_id'=>$article_id,'user_id'=>$v_user_id))
                    ->get()->row_array();
            //set view variable love to show love article else you can love this article
            if ($is_loved) {
                $this->load->vars('isloved', true);
                return true;
            } else {
                $this->load->vars('isloved', false);
                return false;
            }
        }
    }

    public function archive()
    {
        //check mobile page
        if ($this->agent->is_mobile()) {
            $this->m_archive();
            return ;
        }
        $this->site_model->increase_site_hits();

        $view_data = array();

        $article_id = $this->uri->rsegment(3);
        if (empty($article_id) or ! is_numeric($article_id)) {
            show_404();
        } else {
            $article_id = intval($article_id);
        }
        $article = $this->article_model->f_get_by_id($article_id);
        if (empty($article)) {
            show_404();
        }

        //to create variable of article love status
        $this->check_love_article($article_id);

        $this->article_model->increase_hit($article['id']);

        //get category
        $category = $this->article_cat_model->get_by_id($article['category_id']);
        if (empty($category)) {
            show_404();
        }


        //find if is the index article
        $index_article = $this->db->from(TABLE_ARTICLE_INDEX)->where('article_id', $article['id'])->get()->row_array();
        if (! empty($index_article)) {
            $view_data['index_article'] = $index_article;
        }

        $article['imgs']                = $this->file_model->get_imgs_by_object_id($article['id']);
        $view_data['article']           = $article;
        $view_data['navs']              = $this->nav_model->get_list(1, 11, 0);
        $view_data['bread_path']        = $this->article_cat_model->get_nav_path($article['category_id']);
        $view_data['next_article']
        = $this->article_model->get_next_article($article['id'],
                    array('class' => 'p-essay next-essay', 'category_id'=>$article['category_id']));
        $view_data['prev_article']
        = $this->article_model->get_prev_article($article['id'],
                    array('class' => 'p-essay previous-essay', 'category_id'=>$article['category_id']));
        $view_data['week_hot']          = $this->article_model->get_week_hot();
        $view_data['date_archive_html'] = $this->article_model->get_archive_html();
        $view_data['title'] = $article['title'] . '-' . $category['name'] . '-';
        $view_data['category'] = $category;

        $this->load->view('front/welcome/archive_view', $view_data);
    }

    public function photo_archive()
    {
        if ($this->agent->is_mobile()) {
            $this->m_photo_archive();
            return ;
        }

        $this->site_model->increase_site_hits();
        $article_id = $this->uri->rsegment(3);
        $cur_image_index = $this->uri->rsegment(4);

        if (empty($cur_image_index) or ! is_numeric($cur_image_index)) {
            $cur_image_index = 0;
        } else {
            $cur_image_index = intval($cur_image_index);
        }

        if (empty($article_id) or ! is_numeric($article_id)) {
            show_404();
        } else {
            $article_id = intval($article_id);
        }

        $article = $this->article_model->get_by_id($article_id);
        if (empty($article)) {
            show_404();
        }
        $this->article_model->increase_hit($article['id']);

        $photoes = $this->file_model->get_imgs_by_object_id($article_id);

        if ($cur_image_index <= 0) {
            $cur_image_index = 0;
            if (count($photoes) == 1) {
                $next_image_index = $pre_image_index = 0;
            } else {
                $pre_image_index = 0;
                $next_image_index = $cur_image_index + 1;
            }
        } elseif ($cur_image_index >= (count($photoes) - 1)) {
            $cur_image_index = count($photoes) - 1;
            if (count($photoes) == 1) {
                $next_image_index = $pre_image_index = 0;
            } else {
                $pre_image_index = $cur_image_index - 1;
                $next_image_index =     $cur_image_index;
            }
        } else {
            $pre_image_index = $cur_image_index - 1;
            $next_image_index =     $cur_image_index + 1;
        }

        $view_data['article']   = $article;
        $view_data['photoes']   = $photoes;
        $view_data['navs']      = $this->nav_model->get_list(1, 11, 0);
        $view_data['bread_path'] = $this->article_cat_model->get_nav_path($article['category_id']);
        $view_data['cur_image'] = $photoes[$cur_image_index];
        $view_data['pre_pic']   = site_url('photo_archive/' . $article['id'] . '/' . $pre_image_index);
        $view_data['next_pic']  = site_url('photo_archive/' . $article['id'] . '/' . $next_image_index);
        $view_data['cur_image_index']   = $cur_image_index;
        $view_data['latest_images']         = $this->article_model->get_front_list(5, 0, $article['category_id']);
        $view_data['title']         = $article['title'] . '-' . $article['category_name'] . '-';

        $this->load->view('front/welcome/old_photo_archive_view', $view_data);
    }

    public function li()
    {
        if ($this->agent->is_mobile()) {
            $this->m_l();
            return ;
        }
        $this->site_model->increase_site_hits();

        $category_id = $this->uri->rsegment(3);
        $offset = $this->input->get('offset');
        if (empty($category_id)) {
            show_404();
        }

        if (is_numeric($category_id)) {
            $category_id = intval($category_id);
            $article_cat = $this->article_cat_model->get_by_id($category_id);
        } else {
            $alias = $category_id;
            $article_cat = $this->article_cat_model->get_one_by_alias($alias);

            if (! empty($article_cat)) {
                $category_id = $article_cat['id'];
            }
        }

        if (empty($article_cat)) {
            show_404();
        }

        if (empty($offset) || ! is_numeric($offset)) {
            $offset = 0;
        } else {
            $offset = intval($offset);
        }

        $page_config = $this->config->item('front_page_config');

        $cond = array(
            'category_id'   => $article_cat['id'],
            );
        $page = $this->article_model->get_front_pages($page_config['per_page'], $offset, $cond);
        $page_config['total_rows'] = $page['total_rows'];
        $page_config['base_url'] = site_url('l/'.$category_id);
        $this->load->library('pagination');
        $this->pagination->initialize($page_config);


        $view_data['articles']          = $page['data_list'];
        $view_data['pager']             = $this->pagination->create_links();
        $view_data['title']             = $article_cat['name'] . '-' . $this->site_model->get_site_name(1);
        $view_data['bread_path']        = $this->article_cat_model->get_nav_path($article_cat['id']);
        $view_data['navs']              = $this->nav_model->get_list(1, 11, 0);
        $view_data['week_hot']          = $this->article_model->get_week_hot();
        $view_data['date_archive_html'] = $this->article_model->get_archive_html();

        $this->load->view('front/li_view', $view_data);
    }

    public function date_archive()
    {
        $this->site_model->increase_site_hits();
        $this->load->helper('text');
        $date = $this->uri->rsegment(3);

        if ($i = strpos($date, '-')) {
            $yeas = intval(substr($date, 0, $i));
            $month = intval(substr($date, $i + 1));
            $safe_date = $yeas . '-' . sprintf('%02d', $month);
        } else {
            show_404();
        }

        $start_time = strtotime($safe_date);
        $end_time = strtotime($yeas . '-' . sprintf('%02d', $month + 1));
        $start_date = date(DATE_FORMAT, $start_time);
        $end_date = date(DATE_FORMAT, $end_time);

        $cond = array(
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            );

        $offset = $this->input->get('offset');
        if (empty($offset)) {
            $offset = 0;
        }
        $page_config = $this->config->item('front_page_config');

        $page = $this->article_model->get_front_pages($page_config['per_page'], $offset, $cond);

        $page_config['base_url']    = site_url('welcome/date_archive/' . $safe_date);
        $page_config['total_rows']  = $page['total_rows'];
        $this->pagination->initialize($page_config);

        $view_data['articles']      = $page['data_list'];
        $view_data['pager']         = $this->pagination->create_links();
        $view_data['bread_path']    = '<a href="'.site_url().'" >首页</a> > ' . $safe_date . '归档';
        $view_data['navs']          = $this->nav_model->get_list(1, 11, 0);
        $view_data['week_hot']      = $this->article_model->get_week_hot();
        $view_data['date_archive_html'] = $this->article_model->get_archive_html();

        $this->load->view('front/welcome/date_archive_view', $view_data);
    }

    //文章赞 ajax 接口
    public function do_like_ajax()
    {
        $this->output->set_header('Content-Type:application/json;charset=utf-8');

        if ($_POST) {
            $article_id = $this->input->post('article_id');
            // print_r($article_id);
            if (empty($article_id)) {
                echo '{"status" : 500, "message" : "文章ID不存在"}';
                exit();
            } else {
                $article_id = intval($article_id);
            }
            
            $this->load->model('user_model');
            $this->load->model('article_love_model');
            $this->load->helper('summer_view');
            $ip_addr = $this->input->ip_address();
            $user_id = $this->input->post('v_user_id', true);
            if (! empty($user_id)) {
                $user_id = stripslashes($user_id);
            } else {
                $user_id = $this->user_model->get_v_user_id();
            }
            //check if this user has loved the article
            //one ip address has the 100 max love one article
            $count = $this->db->select('count(*) as count')->from(TABLE_ARTICLE_LOVE)
                ->where(array('article_id'=>$article_id,'ip_addr'=>$ip_addr))
                ->get()
                ->row_array();
            $count = $count['count'];
            if ($count > 100) {
                echo json_msg('warning', '你已经赞过了o');
                return ;
            }

            //check if this user id has love the article

            $is_loved = $this->db->from(TABLE_ARTICLE_LOVE)
                        ->where(array('article_id'=>$article_id,'user_id'=>$user_id))
                        ->get()->row_array();
            if ($is_loved) {
                echo json_msg('warning', '你已经赞过了');
                return ;
            }
            
            $this->article_love_model->increase_artilce_love($article_id, $user_id, $ip_addr);
            echo json_msg('success', '赞成功');
        } else {
            json_msg('error', '文章不存在');
            return ;
        }
    }

    public function m_index()
    {
        $this->site_model->increase_site_hits();

        $offset = $this->input->get('offset');
        if (empty($offset) or ! is_numeric($offset)) {
            $offset = 0;
        }


        $page = $this->article_model->get_front_pages(20, $offset, array("is_top"=>0));
        $top_article = $this->article_model->get_front_pages(5, 0, array("is_top"=>1));

        $page["data_list"] = array_merge_recursive($top_article["data_list"], $page["data_list"]);

        $data_view['navs']      = $this->nav_model->get_mobile_nav(4, 10, 0);

        $data_view['sliders']   = $this->slider_model->f_get_list(50, 0);
        $data_view['articles']  = $page['data_list'];

        $this->load->view('front/mobile/welcome_view', $data_view);
    }

    public function m_l()
    {
        $this->site_model->increase_site_hits();
        $category_id_alias = $this->uri->rsegment(3);

        if (empty($category_id_alias)) {
            show_404();
        }

        if (is_numeric($category_id_alias)) {
            $category_id = intval($category_id_alias);
            $category = $this->article_cat_model->get_by_id($category_id);
            if (empty($category)) {
                show_404();
            }
        } else {
            $category_alias = stripslashes($category_id_alias);
            $category = $this->article_cat_model->get_one_by_alias($category_alias);
            if (empty($category)) {
                show_404();
            }
        }

        $articles = $this->article_model->get_front_list(20, 0, $category['id']);

        $view_data['articles']  = $articles;
        $view_data['category']  = $category;
        $view_data['navs']      = $this->nav_model->get_mobile_nav(4, 10, 0);
        $view_data['title']     = $category['name'] . '-';

        $this->load->view('front/mobile/li_view', $view_data);
    }

    public function m_archive()
    {
        $this->site_model->increase_site_hits();
        $article_id = $this->uri->rsegment(3);
        if (empty($article_id) or ! is_numeric($article_id)) {
            show_404();
        }
        $article = $this->article_model->f_get_by_id($article_id);
        if (empty($article)) {
            show_404();
        }
        $this->check_love_article($article['id']);
        $this->article_model->increase_hit($article['id']);

        $view_data['article']   = $article;
        $view_data['navs']      = $this->nav_model->get_mobile_nav(4, 10, 0);
        $view_data['title']         = $article['title'] . '-' . $article['category_name'] . '-';

        $this->load->view('front/mobile/article_archive_view', $view_data);
    }

    public function m_photo_archive()
    {
        $this->site_model->increase_site_hits();
        $article_id = $this->uri->rsegment(3);
        if (empty($article_id) || ! is_numeric($article_id)) {
            show_404();
        }

        $article = $this->article_model->get_by_id($article_id);
        if (empty($article)) {
            show_404();
        }
        $this->article_model->increase_hit($article['id']);
        $photoes = $this->file_model->get_imgs_by_object_id($article['id']);

        $view_data['article']   = $article;
        $view_data['photoes']   = $photoes;
        $view_data['navs']      = $this->nav_model->get_mobile_nav(4, 10, 0);
        $view_data['title']         = $article['title'] . '-' . $article['category_name'] . '-';

        $this->load->view('front/mobile/m_photo_archive_view', $view_data);
    }


    public function m_load_more_news()
    {
        $limit = $this->input->get('limit', true);
        $offset = $this->input->get('offset', true);

        if (empty($limit) || ! is_numeric($limit)) {
            $limit = 10;
        } else {
            $limit = intval($limit);
            if ($limit > 100) {
                $limit = 100;
            }
        }

        if (empty($offset) || ! is_numeric($limit)) {
            $offset = 0;
        } else {
            $offset = intval($offset);
        }

        $cond = array('is_top'  => '0');

        $category_id = $this->input->get('category_id');
        if (!empty($category_id) and is_numeric($category_id)) {
            $category_id = intval($category_id);
            $cond['category_id'] = $category_id;
        }

        $page = $this->article_model->get_front_pages($limit, $offset, $cond);
        $news = $page['data_list'];

        $return_str = '';

        if (empty($news)) {
            echo '';
            return;
        }

        foreach ($news as &$v) {
            $href = archive_url($v);
            $return_str .= '<dl><dt class="artitle_author_date"><div class="summer-index-cat">';
            $return_str .= $v['category_name'] . '</div><div class="summer-index-date">';
            $return_str .= $v['publish_date'] . '</div></dt>';
            if (! empty($v['cover_img'])) {
                $return_str .= '<dd class="m"><a href="'.$href.'">';
                $return_str .= '<img src="'.resource_url($v['cover_img']).'" alt="'.$v['title'].'"></a></dd>';
            }
            $return_str .= '<dt class="zjj_title"><a href="'.$href  .'">'.$v['title'].'</a></dt>';
            $return_str .= '<dd class="cr_summary">'.$v['summary'].'</dd>';
            $return_str .= '<dd class="summer-index-tail"><span class="summer-index-like">'
                        .$v['love'].
                            '</span><span class="summer-index-hits">'.$v['hits'].'</span></dd></dl>';
        }

        echo $return_str;
    }

    public function load_flow_article()
    {
        $this->output->set_header('Content-Type:text/html;charset=utf-8');
        
        $page = $this->input->get('page');
        if (empty($page)) {
            echo '[]';
        } else {
            $page = intval($page);
            if ($page < 2) {
                $page = 2;
            }
        }
        
        $where = array('is_top'=>false, 'is_delete'=>'0', 'status'=>'1');
        $category_id = $this->input->get('category_id');
        if (! empty($category_id) and is_numeric($category_id)) {
            $where['category_id'] = intval($category_id);
        }

        $articles = $this->db->select('id,title,category_id,category_name,summary,is_redirect,
                      love,hits,left(publish_date, 10) as show_date')->from(TABLE_ARTICLE)
                      ->where($where)->limit(($page-1)* 20, 20)->order_by('publish_date desc')
                      ->get()->result_array();
        
        $return_str = '';

        if (empty($articles) || ! is_array($articles)) {
            echo '';
            return;
        }

        foreach ($articles as &$v) {
            $href = archive_url($v);
            $return_str .= '<dl><dt class="artitle_author_date"><div class="summer-index-cat">';
            $return_str .= $v['category_name'] . '</div><div class="summer-index-date">';
            $return_str .= $v['show_date'] . '</div></dt>';
            if (! empty($v['cover_img'])) {
                $return_str .= '<dd class="m"><a href="'.$href.'">';
                $return_str .= '<img src="'.resource_url($v['cover_img']).'" alt="'.$v['title'].'"></a></dd>';
            }
            $return_str .= '<dt class="zjj_title"><a href="'.$href  .'">'.$v['title'].'</a></dt>';
            $return_str .= '<dd class="cr_summary">'.$v['summary'].'</dd>';
            $return_str .= '<dd class="summer-index-tail"><span class="summer-index-like">'.$v['love'].
                            '</span><span class="summer-index-hits">'.$v['hits'].'</span></dd></dl>';
        }

        echo $return_str;
    }
}
