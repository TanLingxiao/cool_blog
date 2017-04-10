<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
	
	<!-- 引入jQuery，判断一下浏览器版本，2.0及以上不支持IE9以下浏览器 -->
	<!--[if lt IE 9]>
	<script src="http://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
	<script src="http://cdn.staticfile.org/respond.js/1.3.0/respond.min.js"></script>
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<!--[else]>
	<script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
	<![endif]-->
	
	<!-- 引入Bootstrap的CSS和JS文件 -->
	<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- 使用url函数转换相关路径 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/grid.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">
	
	<!-- 引入风格CSS和JS文件 -->
	<script src="<?php $this->options->themeUrl('js/modernizr-2.6.2.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/normalize.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/owl-carousel.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/templatemo-style.css'); ?>">
	
    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
</head>
<body>
<!--[if lt IE 8]>
    <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.</div>
<![endif]-->
<?php $this->need('sidebar.php'); ?>
    
    
