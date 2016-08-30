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
<?php echo get_sidebar() ?>
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

