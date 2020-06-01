<?php

/**
 * 这是Sloger的包含bootstrap和semantic的主题
 * 
 * @package Boot-Sematic Theme
 * @author Sloger
 * @version 1.0
 * @link http://blog.sloger.info
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
    $this->need('header.php');
?>

<div class="main">
    <?php while($this->next()): ?>
    <article class="block post">
        <span class="round-date <?php $this->options->labelColor() ?>">
            <span class="month"><?php $this->date('m月'); ?></span>
            <span class="day"><?php $this->date('d'); ?></span>
        </span>
        <p class="title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></p>
        <p class="article-meta">本文由 <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a> <?php $this->date('发表于 Y 年 m 月 d 日'); ?></p>
        <div class="ui ribbon label <?php $this->options->labelColor() ?>"><?php $this->category(','); ?></div>
            <div class="article-content <?php $this->options->labelColor() ?>">
                <?php $this->content('阅读全文 >>'); ?>
            </div>
        </article>
    <?php endwhile; ?>
    <?php $this->pageNav('<< 上一页', '下一页 >>'); ?>
</div>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
