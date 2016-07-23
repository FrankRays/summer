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
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li><a href="admin-index.html"><span class="am-icon-home"></span> 首页</a></li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}"><span class="am-icon-file"></span> 内容管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">
                        <li><a href="<?php echo site_url('c=post') ?>" class="am-cf"><span class="am-icon-check"></span> 本地文章管理<!-- <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span> --></a></li>
                        <li><a href="<?php echo site_url('c=article_index&m=index') ?>" class="am-cf"><span class="am-icon-check"></span>首页文章管理</a></li>
                        <li><a href="<?php echo site_url('c=article_category&m=index') ?>"><span class="am-icon-puzzle-piece"></span> 文章分类管理</a></li>
                        <li><a href="<?php echo site_url('d=config&c=slider&m=index') ?>"><span class="am-icon-puzzle-piece"></span> 幻灯片管理</a></li>
                       <!--  <li><a href="admin-404.html"><span class="am-icon-bug"></span> 404</a></li> -->
                    </ul>
                </li>
                 <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#photo-manage'}"><span class="am-icon-file"></span> 图片文章管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub am-in" id="photo-manage">
                        <li><a href="<?php echo site_url('c=post&category_id=8') ?>" class="am-cf"><span class="am-icon-check"></span> 图片新闻<!-- <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span> --></a></li>
                        <li><a href="<?php echo site_url('c=post&category_id=7') ?>"><span class="am-icon-puzzle-piece"></span> 光影交院</a></li>
                        <li><a href="<?php echo site_url('c=post&category_id=10') ?>"><span class="am-icon-puzzle-piece"></span>校园写意</a></li>
                       <!--  <li><a href="admin-404.html"><span class="am-icon-bug"></span> 404</a></li> -->
                    </ul>
                </li>
                <li><a href="<?php echo site_url('c=user&m=logout') ?>"><span class="am-icon-sign-out"></span> 注销</a></li>
            </ul>

            <div class="am-panel am-panel-default admin-sidebar-panel">
                <div class="am-panel-bd">
                    <p><span class="am-icon-bookmark"></span> 更新（7-9）</p>
                    <ol>
                       <li>后台管理作大幅度人性化调整</li>
                       <li>前台增加手机端页面</li> 
                       <li>电脑端页面优化</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- sidebar end -->