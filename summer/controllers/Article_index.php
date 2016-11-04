<?php
defined('BASEPATH') || exit('no direct script access allowed');


//交院www主站新闻抓取管理
class Article_index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('news_index_model');
        $this->load->model('article_model');
        $this->load->model('source_model');
    }

    public function index()
    {
        $view_data['module_name'] = '首页新闻管理';
        $view_data['module_desc'] = '';

        $get = $this->input->get();
        $offset = isset($get['offset']) ? intval($get['offset']) : 0;
        $category_id = isset($get['category_id']) ? intval($get['offset']) : 0;

        $cond['type'] = ARTICLE_TYPE_INDEX;
        if (isset($get['category_id'])) {
            $cond['category_id'] = $category_id;
        }

        $page_config = $this->config->item('page_config');
        $page = $this->article_model->get_pages($offset, $page_config['per_page'], $cond);

        if (isset($get['offset'])) {
            unset($get['offset']);
        }

        $base_url_params = array();
        foreach ($get as $k => $v) {
            $base_url_params[] = $k . '=' . $v;
        }
        $page_config['base_url'] = site_url(implode($base_url_params, '&'));
        $page_config['total_rows'] = $page['total_rows'];

        $this->pagination->initialize($page_config);
        $view_data['page_link'] = $this->pagination->create_links();
        $view_data['page']      = $page;

        $this->_load_view('default/article_index_browse_view', $view_data);
    }

    //从首页爬去文章
    public function crawl_index_news()
    {
        $this->load->library('crawler');

        $article_urls = $this->_get_article_urls();

        $fail_num = 0;
        foreach ($article_urls as $v) {
            $article_url = $v[0];
            $category_id = $v[1];
            $index_id = $v[2];
            $index_order = $v[3];
            switch ($category_id) {
                case INDEX_CID_COLLEGE_NEWS:
                    $category_name = INDEX_CNAME_COLLEGE_NEWS;
                    break;
                case INDEX_CID_DEPART_NEWS:
                    $category_name = INDEX_CNAME_DEPART_NEWS;
                    break;
                case INDEX_CID_NOTATION:
                    $category_name = INDEX_CNAME_NOTATION;
                default:
                    $category_name = INDEX_CNAME_NOTATION;
                    break;
            }

            $article = $this->article_model->get_by_index_id($index_id);
            $article_page_content = $this->crawler->get_content($article_url);
            if ($article_page_content === false) {
                continue ;
            }

            $new_article = $this->crawler->handle_view_content_page($article_page_content);
            $new_article['content'] = $this->_change_article_imgsrc_to_absorlute_index($new_article['content']);
            $new_article['summary'] = $this->_get_article_summary($new_article['content']);
            if (! empty($article)) {
                //更新
                $update_article = array(
                    'title'             => addslashes($new_article['title']),
                    'category_id'   => intval($category_id),
                    'category_name'     => addslashes($category_name),
                    'summary'       => $new_article['summary'],
                    'author_name'=> addslashes($new_article['publisher']),
                    'content'       => $new_article['content'],
                    'create_time'   => $new_article['create_date'],
                    'create_date'   => $new_article['create_date'],
                    'publish_date'  => $new_article['create_date'],
                    );

                $this->article_model->update_by_index_id($update_article, $index_id);
            } else {
                //插入
                $insert_article = array(
                    'index_id'      => $index_id,
                    'title'             => $new_article['title'],
                    'category_id'   => $category_id,
                    'category_name'     => $category_name,
                    'type'          => ARTICLE_TYPE_INDEX,
                    'summary'       => $new_article['summary'],
                    'publisher_name'=> $new_article['publisher'],
                    'content'       => $new_article['content'],
                    'hits'          => $new_article['article_hits'],
                    'create_time'   => $new_article['create_date'],
                    'create_date'   => $new_article['create_date'],
                    'status'        => ARTICLE_STATUS_PUBLIC,
                    'is_delete'         => 0,
                    );
                $insert_id = $this->article_model->create($insert_article);
            }
        }

        redirect(site_url('c=article_index&m=index'));
    }

    //从首页列表获取文章首页的文章正文链接数据。
    private function _get_article_urls()
    {
        $xyxw_list_url = $this->config->item('www_url_xyxw');
        $xbdt_list_url = $this->config->item('www_url_xbdt');
        $tzgg_list_url = $this->config->item('www_url_tzgg');

        $list_urls = array($xyxw_list_url, $xbdt_list_url, $tzgg_list_url);
        $article_urls = array();
        foreach ($list_urls as $v) {
            $list_content = $this->crawler->get_content($v);
            if (! $list_content) {
                exit('not find list content - ' . $v );
            }

            $list_array = $this->crawler->handle_view_li_page($list_content);
            if (! $list_array) {
                show_error('处理页面失败 - ' . $v);
                exit();
            }
            $article_urls = array_merge($article_urls, $list_array);
        }

        return $article_urls;
    }

    private function _get_article_summary($content)
    {
        //获取文章的描述字段
        $clearly_content = strip_tags($content);
        $clearly_content = preg_replace('/\s/', '', $clearly_content);
        if (mb_strlen($clearly_content) > 40) {
            $summary = mb_substr($clearly_content, 0, 40) . '...';
        } else {
            $summary = $content;
        }

        return $summary;
    }

    public function create_index_article()
    {
        if (! $this->user_model->verify()) {
            redirect('c=user&m=login');
        }
        $data_view['module_name']   = '新增首页文章';
        $data_view['bread_path']    = get_module_path(array(
            array('新闻列表',       site_url('c=post&m=index')),
            array('新增首页新闻',     ''),
            ));
        $data_view['post_url']      = site_url('c=article_index&m=create_index_article');

        $href = $this->input->post('href');

        if ($_POST && $this->_check_form()) {
            if ($this->article_model->create_index_article($href)) {
                // redirect(site_url('c=post&m=index'));
                echo "success";
            } else {
                $this->form_validation->set_error_array(array('更新首页文章失败'));
            }
        }

        $this->_load_view('default/article_index/create_index_article_view', $data_view);
    }

    public function batch_fetch_index_article()
    {
        set_time_limit(100000);

        $page_size = $this->input->get('page_size');
        if (empty($page_size)) {
            $page_size = 5;
        } else {
            $page_size = intval($page_size);
        }

        $href = 'http://www.svtcc.edu.cn/front/list-12.html?pageNo=1&pageSize=' . $page_size;
        $this->article_model->get_index_artcile_list($href);
        $href = 'http://www.svtcc.edu.cn/front/list-11.html?pageNo=1&pageSize=' . $page_size;
        $this->article_model->get_index_artcile_list($href);
        $href = 'http://www.svtcc.edu.cn/front/list-16.html?pageNo=1&pageSize=' . $page_size;
        $this->article_model->get_index_artcile_list($href);
        set_flashalert('批量获取首页文章成功');
        redirect(site_url('c=post&m=index'));
    }

    public function manu_www_crawler()
    {
        $this->www_crawler(0);
        $this->www_crawler(1);
        $this->www_crawler(2);
        set_flash_msg('获取首页文章成功');
        redirect(site_url('c=post&m=browse'), 'success');
    }

    public function www_crawler($page_url_code = 0, $page_no = 1, $page_size = 10)
    {
        $this->load->model('user_model');
        $this->user_model->is_admin();
        $this->load->helper('simple_html_dom_helper');
        $page_url_map = array('http://www.svtcc.edu.cn/front/list-11.html',
                    'http://www.svtcc.edu.cn/front/list-12.html',
                    'http://www.svtcc.edu.cn/front/list-16.html');
        $page_url = $page_url_map[$page_url_code];
        if (empty($page_url)) {
            exit('no set this $page_url_code : ' . $page_url_code);
        }

        $page_url .= '?pageNo=' . intval($page_no) . '&pageSize=' . intval($page_size);
        $html = file_get_html($page_url);
        $ret = $html->find('.szlbys_content ul', 0)->find('li a');

        $url_queue  = array();
        foreach ($ret as $a) {
            array_unshift($url_queue, 'http://www.svtcc.edu.cn' . $a->href);
        }

        foreach($url_queue as $request_url) {
            $html = file_get_html($request_url);
            if (! empty($html)) {
                $this->_crawl_article_content($html, $request_url);
            }
        }
    }

    public function www_crawler_single()
    {
        exit();
        $request_url = 'http://www.svtcc.edu.cn/front/view-12-8dab6616157e4c839d140b3ce05c08a7.html';
        $this->load->helper('simple_html_dom_helper');
        $html = file_get_html($request_url);
        if (! empty($html)) {
            $this->_crawl_article_content($html, $request_url);
        }
    }

    private function _crawl_article_content($html, $request_url)
    {
        $article_dom = $html->find('#newscontent', 0);
        $title_dom = $article_dom->find('h3', 0);
        $title = $title_dom->plaintext;
        $article_info_dom = $title_dom->next_sibling();
        $article_info = $article_info_dom->plaintext;
        preg_match('/发布者：(.*?) &/', $article_info, $author_name);
        preg_match('/点击数：(.*?) &/', $article_info, $hits);
        preg_match('/发布时间：(\d{4}-\d{2}-\d{2})/', $article_info, $publish_date);
        $author_name = $author_name[1];
        $hits = $hits[1];
        $publish_date = $publish_date[1];

        //deal article content img tag src replace to www absolute src
        $article_content_dom = $article_info_dom->next_sibling();
        $article_imgs = $article_content_dom->find('img');
        foreach ($article_imgs as &$imgs) {
            $imgs->src = 'http://www.svtcc.edu.cn' . $imgs->src;
            $imgs->style = 'width:100%';
            $img_copy = $imgs;
            do {
                $img_copy = $img_copy->parent();
            } while (! empty($img_copy) and $img_copy->tag != 'p');

            if (! empty($img_copy)) {
                $img_copy->style = '';
            }
        }

        //deal article content a tag href replace to www abolute href
        $article_atags = $article_content_dom->find('a');
        foreach ($article_atags as &$atag) {
            if (! strpos($atag->href, 'http://') and  ! strpos($atag->href, 'https://')) {
                if (strpos($atag->href, 'userfiles')) {
                    $atag->href = 'http://www.svtcc.edu.cn' . $atag->href;
                }
            }
        }

        $content = $article_content_dom->innertext;

        $category_map = array(
            '11' => array(
                'category_id'=>'2',
                'category_name'=>'学院新闻'),
            '12' => array(
                'category_id'=>'1',
                'category_name'=>'通知公告',
                ),
            '16' => array(
                'category_id'=>'3',
                'category_name'=>'系部动态',
                ),
            );
        $category_id = explode('-', $request_url);
        $category = $category_map[$category_id[1]];
        $index_article_id = $category_id[2];
        $index_article_id = substr($index_article_id, 0, strpos($index_article_id, '.'));
        if(mb_strlen($content) > 64) {
            $summary = mb_substr($content, 0, 64);
        } else {
            $summary = $content;
        }

        $insert_article = array(
            'title'         => $title,
            'category_id' => $category['category_id'],
            'category_name'=>$category['category_name'],
            'content'   => $content,
            'hits'      => $hits,
            'author_name'   => $author_name,
            'publish_date'  => $publish_date,
            'index_id'      => $index_article_id,
            'status'        => '1',
            'is_delete'         => '0',
            'summary'       =>$summary,
            );

        $old_article = $this->db->from(TABLE_ARTICLE)->where('index_id', $index_article_id)
                        ->get()->row_array();
        if (empty($old_article)) {
            $this->db->insert(TABLE_ARTICLE, $insert_article);
            $insert_article['id'] = $this->db->insert_id();
        } else {
            $this->db->where('id', $old_article['id'])->update(TABLE_ARTICLE, $insert_article);
            $insert_article['id'] = $old_article['id'];
        }

        $old_www_article = $this->db->from(TABLE_ARTICLE_INDEX)
                                ->where('article_id', $insert_article['id'])
                                ->get()
                                ->row_array();
        $insert_index_article = array(
            'article_id'    => $insert_article['id'],
            'index_id'      => stripslashes($index_article_id),
            'category_id'   => intval($category_id[1]),
            'category_name'     => $insert_article['category_name'],
            'index_create_date'     => $publish_date,
            'www_href'      => $request_url
            );
        if (empty($old_www_article)) {
            $this->db->insert(TABLE_ARTICLE_INDEX, $insert_index_article);
        } else {
            $this->db->where('article_id', $insert_article['id'])->update(TABLE_ARTICLE_INDEX, $insert_index_article);
        }
    }


    private function _check_form()
    {
        $this->form_validation->set_rules(array(
            array(
                'field'=>'href',
                'label'=>'文章链接',
                'rules'=>'required|valid_url|callback__valid_index_href',
                ),
            ));

        $result = $this->form_validation->run();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function _valid_index_href($str)
    {
        if (strpos($str, 'http://www.svtcc.edu.cn/front/view-') !== false) {
            return true;
        } else {
            $this->form_validation->set_message('_valid_index_href', '文章链接不正确');
            return false;
        }
    }

    private function _change_article_imgsrc_to_absorlute_index($content)
    {
            return preg_replace('/<img.*?src="(.*?)".*?>/',
             '<img src="http://www.svtcc.edu.cn/$1" />', $content);
    }
}
