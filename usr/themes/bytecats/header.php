<!--[if lte IE 8]><script>(function(){var e="abbr,article,aside,audio,canvas,datalist,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video".split(','),i=e.length;while(i--){document.createElement(e[i]);}}());</script><![endif]-->
<!DOCTYPE html>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<html>
<head>
<meta charset="<?php $this->options->charset(); ?>">
<link href="<?php $this->options->themeUrl('img/favicon.ico'); ?>" rel="shortcut icon"  type="image/x-icon">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php $this->archiveTitle(array(
        'category'  =>  _t('分类 %s 下的文章'),
        'search'    =>  _t('包含关键字 %s 的文章'),
        'tag'       =>  _t('标签 %s 下的文章'),
        'author'    =>  _t('%s 发布的文章')
    ), '', ' | '); ?><?php $this->options->title(); ?><?php if($this->is('index')){echo " | 学习 记录 分享"; }?></title>

<!-- 使用url函数转换相关路径 -->
<link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">
<!-- 通过自有函数输出HTML头部信息 -->
<?php $this->header('generator=&template=&pingback=&xmlrpc=&wlw=&rss1=&rss2=&atom=&commentReply='); ?>
</head>
<body>
<header id="header">
    <div class="container" id="top">
            <div class="grid-1-4">
                <hgroup id="logo">
                    <h1><a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a></h1>
                    <h2><?php $this->options->description() ?></h2>
                </hgroup>      
            </div>
    </div>
    <div id="menu-bar">
        <div class="container">
            <nav id="nav-menu" class="clearfix" role="navigation">
                <a<?php if($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php while($pages->next()): ?>
                <a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                <?php endwhile; ?>
            </nav>
        </div>
    </div>
</header><!-- end #header -->
<div id="body">
    <div class="container">
        <div class="row">

    
    
