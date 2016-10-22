<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>交院新闻中心 | snowCMS by ykjver</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="<?php echo base_url('source/AmazeUI-2.1.0/assets/css/amazeui.min.css') ?>"/>
  <link rel="stylesheet" href="<?php echo base_url('source/AmazeUI-2.1.0/assets/css/admin.css')?>" />
  <!--[if lt IE 9]>
  <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
  <![endif]-->
  <!--[if (gte IE 9)|!(IE)]><!-->
  <script src="<?php echo base_url('source/AmazeUI-2.1.0/assets/js/jquery.min.js') ?>"></script>
  <!--<![endif]-->

  <!-- layerdate -->
  <script type="text/javascript" src="<?php echo base_url('source/laydate/laydate.js') ?>"></script>
  <!-- layerdate -->

<!--  ueditor-->

  <script type="text/javascript" charset="utf-8" src="<?php echo  base_url('source/ueditor/ueditor.config.js') ?>"></script>
  <script type="text/javascript" charset="utf-8" src="<?php echo  base_url('source/ueditor/ueditor.all.min.js') ?>"> </script>
  <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
  <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
  <script type="text/javascript" charset="utf-8" src="<?php echo  base_url('source/ueditor/lang/zh-cn/zh-cn.js') ?>"></script>
<!--  ueditor-->

<!-- chose plugin -->
  <script type="text/javascript" src="<?php echo base_url("statics/plugins/chosen/amazeui.chosen.min.js") ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url("statics/plugins/chosen/amazeui.chosen.css") ?>">
<!-- chose plugin -->

<?php echo html_resource('css') ?>
<?php echo html_resource('head_js') ?>
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar admin-header">
  <div class="am-topbar-brand">
    <strong>snowCMS</strong> <small>交院新闻中心后台</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li>
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> <?php echo cur_user_account() ?> <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>
          <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
          <li><a href="#"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>
