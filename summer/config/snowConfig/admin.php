<?php defined('BASEPATH') || exit('no direct script access allowed');
/**
*y系统私有config
*@author ykjver
**/

/**-----------关于视图-------------**/
//视图的head部分路径
$config['y']['view']['head'] = 'v_01/common/head_view.php';
//视图在foot部分的路径
$config['y']['view']['foot'] = 'v_o1/common/foot_view.php';



$config['upload'] = array();
$config['upload']['thumb'] = array(
        array(100, 100),array(400, 400), array(400, 400)
    );


//分页参数
$config['paginationConfig'] = array(
    'per_page' => '20',
    'query_string_segment' => 'offset',
    'page_query_string' => true,
    'full_tag_open' => '<ul data-am-widget="pagination" class="am-pagination am-pagination-default">',
    'full_tag_close' => '</ul>',
    'first_tag_open' => '<li class="am-pagination-first ">',
    'first_tag_close' => '</li>',
    'last_tag_open' => '<li class="am-pagination-last ">',
    'last_tag_close' => '</li>',
    'cur_tag_open' => '<li class="am-active"><a href="#" class="am-active">',
    'cur_tag_close' => '</a></li>',
    'next_tag_open' => '<li class="am-pagination-next ">',
    'next_tag_close' => '</li>',
    'prev_tag_open' => '<li class="am-pagination-prev ">',
    'prev_tag_close' => '</li>',
    'num_tag_open' => '<li class="">',
    'num_tag_close' => '</li>',
    'first_link' => '第一页',
    'prev_link' => '上一页',
    'next_link' => '下一页',
    'last_link' => '最末页'
);

//databases tables base infomation

$config['table'] = array(
    //新闻网首页
    'index_news' => array(
            'table_name' => 'summer_article_index',
            'fields' => array('id', 'title', 'category_id', 'is_top', 'cover_img'
                , 'index_ctime', 'index_id', 'category_name', 'index_cmitime', 'cur_order'),
        ),
    'config'    => array(
            'table_name'    => 'config',
            'fields'        => array('id', 'owner', 'module', 'section', 'key', 'value'),
        ),
    );