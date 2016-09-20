<?php defined('BASEPATH') || exit('no direct script access allowed'); 

?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">  
    <title><?php echo isset($title) ? $title : '' ?>四川交院新闻网</title>

    <!-- Bootstrap -->
	<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- default css -->
	<link rel="stylesheet" href="<?=static_url('css/mobile/default.css')?>" >

	<!-- light slider -->
	<link rel="stylesheet" type="text/css" href="<?=static_url("plugins/lightslider/css/lightslider.css") ?>">

  </head>
  <body>
  <nav id="summer-mobile-navbar" class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="<?=site_url('m/index')?>">四川交院新闻网</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
	        <?php foreach($navs as $nav){ ?>
	        <li><a href="<?=$nav['href']?>"><?=$nav['label']?></a></li>
	        <?php } ?>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>