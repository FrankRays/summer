<?php
/**
* Created by PhpStorm.
* User: ykjverx
* Date: 2015/1/25
* Time: 18:25
*/
?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <div class="admin-sidebar am-offcanvas" i/"admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li>
                    <a href="admin-index.html">
                        <span class="am-icon-home"></span>
                        首页
                    </a>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}">
                        <span class="am-icon-file"></span>
                        图文文章管理
                        <span class="am-icon-angle-right am-fr am-margin-right"></span>
                    </a>
                    <ul class="am-list am-collapse admin-sidebar-sub am-in" i/"collapse-nav">
                        <li>
                            <a href="<?php echo site_url('/article/y/index') ?>
                                " class="am-cf">
                                <span class="am-icon-check"></span>
                                文章列表
                                <!-- <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span>
                            -->
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('/article/y/create') ?>
                            ">
                            <span class="am-icon-puzzle-piece"></span>
                            发布文章
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('/config/slider/index') ?>
                            ">
                            <span class="am-icon-puzzle-piece"></span>
                            首页幻灯片
                        </a>
                    </li>
                    <!--  <li>
                    <a href="admin-404.html">
                        <span class="am-icon-bug"></span>
                        404
                    </a>
                </li>
                -->
            </ul>
        </li>
        <li class="admin-parent">
            <a class="am-cf" data-am-collapse="{target: '#indexarticle-manage'}">
                <span class="am-icon-file"></span>
                学院首页新闻管理
                <span class="am-icon-angle-right am-fr am-margin-right"></span>
            </a>
            <ul class="am-list am-collapse admin-sidebar-sub am-in" i/"indexarticle-manage">
                <li>
                    <a href="<?php echo site_url('/indexArticle/y/index')."?category_id=1" ?>
                        " class="am-cf">
                        <span class="am-icon-check"></span>
                        学院新闻
                        <!-- <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span>
                    -->
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('/indexArticle/y/index')."?category_id=3" ?>
                    ">
                    <span class="am-icon-puzzle-piece"></span>
                    系部动态
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('/indexArticle/y/doCrawler') ?>
                    ">
                    <span class="am-icon-puzzle-piece"></span>
                    搬运首页新闻
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('/indexarticle/y/doCrawlNewPage') ?>
                    ">
                    <span class="am-icon-puzzle-piece"></span>
                    首页新闻统计
                </a>
            </li>
            <!--  <li>
            <a href="admin-404.html">
                <span class="am-icon-bug"></span>
                404
            </a>
        </li>
        -->
    </ul>
</li>
<li class="admin-parent">
    <a class="am-cf" data-am-collapse="{target: '#photo-manage'}">
        <span class="am-icon-file"></span>
        图片管理
        <span class="am-icon-angle-right am-fr am-margin-right"></span>
    </a>
    <ul class="am-list am-collapse admin-sidebar-sub am-in" i/"photo-manage">
        <li>
            <a href="<?php echo site_url('/article/photo/index')."?category_id=8" ?>
                " class="am-cf">
                <span class="am-icon-check"></span>
                图片新闻
                <!-- <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span>
            -->
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('/article/photo/index')."?category_id=7" ?>
            ">
            <span class="am-icon-puzzle-piece"></span>
            光影交院
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('/article/photo/index')."?category_id=12" ?>
            " class="am-cf">
            <span class="am-icon-check"></span>
            校园写意
                <!-- <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span>
            -->
        </a>
    </li>
</li>
</ul>
</li>
<li class="admin-parent">
<a class="am-cf" data-am-collapse="{target: '#video-manage'}">
<span class="am-icon-file"></span>
视频管理
<span class="am-icon-angle-right am-fr am-margin-right"></span>
</a>
<ul class="am-list am-collapse admin-sidebar-sub am-in video-manage">
<li>
    <a href="<?php echo site_url('/article/video/index') ?>
        " class="am-cf">
        <span class="am-icon-check"></span>
        视频列表
        <!-- <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span>
    -->
</a>
</li>
<li>
<a href="<?php echo site_url('/article/video/create') ?>
    ">
    <span class="am-icon-puzzle-piece"></span>
    添加视频
</a>
</li>
<!--  <li>
<a href="admin-404.html">
<span class="am-icon-bug"></span>
404
</a>
</li>
-->
</ul>
</li>
<!--   <li>
<a href="admin-table.html">
<span class="am-icon-table"></span>
表格
</a>
</li>
<li>
<a href="admin-form.html">
<span class="am-icon-pencil-square-o"></span>
表单
</a>
</li>
-->
<li>
<a href="<?php echo site_url('/user/login/signOut') ?>
">
<span class="am-icon-sign-out"></span>
注销
</a>
</li>
</ul>
<div class="am-panel am-panel-default admin-sidebar-panel">
<div class="am-panel-bd">
<p>
<span class="am-icon-bookmark"></span>
公告
</p>
<p>时光静好，与君语；细水流年，与君同。—— ykjver</p>
</div>
</div>
<!-- <div class="am-panel am-panel-default admin-sidebar-panel">
<div class="am-panel-bd">
<p>
<span class="am-icon-tag"></span>
wiki
</p>
<p>Welcome to the Amaze UI wiki!</p>
</div>
</div>
-->
</div>
</div>
<!-- sidebar end -->