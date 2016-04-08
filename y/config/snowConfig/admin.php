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


//分页配置
$config['paginationConfig'] = array(
    'per_page' => '20',
    'use_page_numbers' => true,
    'query_string_segment' => 'page',
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