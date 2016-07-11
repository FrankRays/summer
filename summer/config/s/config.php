<?php
defined('BASEPATH') || exit('no direct script access allowed');


//svtcc主站，抓取新闻链接
//学院新闻
$config['www_url_xyxw'] = 'http://www.svtcc.edu.cn/front/list-11.html';
//系部动态
$config['www_url_xbdt'] = 'http://www.svtcc.edu.cn/front/list-16.html';
//通知公告
$config['www_url_tzgg']	= 'http://www.svtcc.edu.cn/front/list-12.html';



//分页参数
$config['page_config'] = array(
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

//表单验证配置
$config['form_validation']['error_prefix'] = '<div class="am-alert am-alert-danger" data-am-alert>'.
    '<button type="button" class="am-close">&times;</button><p>';
$config['form_validation']['error_suffix'] = '</p></div>';


//静态路径配置和资源路径配置
$config['static_base_path'] = 'http://127.0.0.1:9999/xww/statics/';
// $config['static_base_path'] = 'http://192.168.2.167/xww/statics/';

$config['resource_base_path'] = 'http://127.0.0.1:9999/xww/resource/';
// $config['resource_base_path'] = 'http://192.168.2.167/xww/resource/';