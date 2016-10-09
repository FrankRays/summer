<?php
defined('BASEPATH') || exit('no direct script access allowed');

$config['cms_version'] = '2.00a';

//site name
$config['site_name'] = '四川交通职业技术学院-新闻网';


//svtcc主站，抓取新闻链接
//学院新闻
$config['www_url_xyxw'] = 'http://www.svtcc.edu.cn/front/list-11.html';
//系部动态
$config['www_url_xbdt'] = 'http://www.svtcc.edu.cn/front/list-16.html';
//通知公告
$config['www_url_tzgg']	= 'http://www.svtcc.edu.cn/front/list-12.html';

//文件上传config
$config['upload_config'] = array(
        'allowed_types'     => 'jpg|png|gif',
        'max_size'          => 20480,
        'max_width'         => '2048',
        'max_height'        => '2048',
        'encrypt_name'      => TRUE,
    ); 

//image resize config
$config['resize_img_config'] = array(
    'image_library'     => 'gd2',
    'create_thumb'      => TRUE,
    'maintain_ratio'    => TRUE,
    'width'             => 640,
    );

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

$config['front_page_config'] = array(
            'per_page' => '20',
            'query_string_segment' => 'offset',
            'page_query_string' => true,
            'full_tag_open' => '',
            'full_tag_close' => '',
            'first_tag_open' => '',
            'first_tag_close' => '',
            'last_tag_open' => '',
            'last_tag_close' => '',
            'cur_tag_open' => '<a class="curr">',
            'cur_tag_close' => '</a>',
            'next_tag_open' => '',
            'next_tag_close' => '',
            'prev_tag_open' => '',
            'prev_tag_close' => '',
            'num_tag_open' => '',
            'num_tag_close' => '',
            'first_link' => '第一页',
            'prev_link' => '上一页',
            'next_link' => '下一页',
            );

//表单验证配置
$config['form_validation']['error_prefix'] = '<div class="am-alert am-alert-danger" data-am-alert>'.
    '<button type="button" class="am-close">&times;</button><p>';
$config['form_validation']['error_suffix'] = '</p></div>';


//静态路径配置和资源路径配置
$config['static_base_path']         = 'http://test.summer.com:9999/statics/';
// $config['static_base_path'] = 'http://192.168.2.167/xww/statics/';

$config['resource_base_path']       = 'http://test.summer.com:9999/resource/';
// $config['resource_base_path'] = 'http://192.168.2.167/xww/resource/';
//资源上传绝对路径
$config['resource_upload_path']     = 'resource';

//sidar link data and authority
$config['sidebar_config'] = array(
    array(
        'href'      => 'c=main',
        'label'     => '主面板',
        'own'       => 'common'
        ),
    array(
        'href'      => '',
        'label'     =>  '内容',
        'own'       => 'common',
        'childern'  => array(
                array(
                    'href'      => 'c=post',
                    'label'     => '文章',
                    'own'       => 'common'
                    ),
                array(
                    'href'      => 'c=post&m=article_create',
                    'label'     => 'create article',
                    'own'       => 'common'
                    ),
                array(
                    'href'      => 'c=slider&m=admin',
                    'label'     => '幻灯片',
                    'own'       => 'common',
                    ),
            ),
        ),
    array(
        'href'      => '',
        'label'     => 'Config',
        'own'       => 'super',
        'childern'  => array(
            array(
                'href'      => 'c=nav&m=admin',
                'label'     => 'Navigation',
                'own'       => 'super',
                ),
            )
        ),
    array(
        'href'      => '',
        'label'     => '用户',
        'own'       => 'common',
        'childern'  => array(
            array(
                'href'      => 'c=user&m=admin',
                'label'     => '用户',
                'own'       => 'super',
                ),
            array('href'=>'c=user&m=change_password', 'label'=>'修改密码', 'own'=>'common'),
            )
        )

    );


$config['photo_category_id'] = array(5, 6, 8, 10);