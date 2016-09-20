<?php defined('APPPATH') || exit('no access'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="description" content="四川交通职业技术学院新闻网，校内网，通知，活动，公告，最新动态，校内服务。">
<meta name="keywords" content="四川交通职业技术学院,新闻,交通,职业技术,大学,AtoB,snow0x01">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo isset($title) ? $title : ''; ?>交院新闻网</title>
<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">
<!-- No Baidu Siteapp-->
<meta http-equiv="Cache-Control" content="no-siteapp"/>

<link rel="stylesheet" href="<?php echo base_url('/source/ft/xww/css/style_1018.css') ?>?version=summer_1101"  type"text/css" />
<link rel="stylesheet" href="<?php echo base_url('/xww/third_party/foundation-icons/foundation-icons.css') ?>" type"text/css" />
<script type="text/javascript" src="<?php echo static_url('js/h/jquery-1.8.3.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/source/layer/layer.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/source/layer/extend/layer.ext.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/source/ft/xww/js/koala.min.1.5.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/source/ckplayer/ckplayer.js') ?>"></script>
</head>

<body>
<div class="summer_container">
<div id="header">
    <div id="header-box">
        <h1><a href="<?php echo site_url() ?>"><img src="<?php echo base_url('/source/ft/xww/images/logo.jpg')?>" /></a></h1>
        <p>新闻网</p>
    </div>
</div>
<div id="nav">
    <div id="nav-box">
        <ul>
        <?php foreach($navs as $v){ ?>
            <li><a href="<?php echo $v['href'] ?>"><?php echo $v['label'] ?></a></li>
        <?php } ?>
        </ul>
    </div>
</div>