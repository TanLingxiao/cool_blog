<?php

    if (isset($_GET["action"]) && $_GET["action"] == "ajax_comments") {
        $this->need('comments.php');
    } else {
        if(strpos($_SERVER["PHP_SELF"],"themes")) header('Location:/');
        $this->need('header.php');

?>

<div class="main">
    <article class="block post">
        <span class="round-date <?php $this->options->labelColor() ?>">
            <span class="month"><?php $this->date('m月'); ?></span>
            <span class="day"><?php $this->date('d'); ?></span>
        </span>
        <p class="title"><?php $this->title() ?></p>
        <p class="article-meta">本文由 <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?> </a><?php $this->date('发表于 Y 年 m 月 d 日'); ?></p>
        <div class="article-content">
            <?php $this->content(); ?>
        </div>
        <p class="tags"><?php _e('标签：'); ?><?php $this->tags(', ', true, 'none'); ?></p>
        <?php if($this->allow('ping')): ?>
            <div class="copyright">
                <div class="article-license">
                    <img height="24" src="https://sf-static.b0.upaiyun.com/v-57d7cc42/global/img/creativecommons-cc.png" class="mb5"><br>
                    <div class="license-item text-muted">
                        本文由 <a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a> 创作，采用 <a class="alert-link" target="_blank" href="http://creativecommons.org/licenses/by/3.0/cn">知识共享署名 3.0</a>，可自由转载、引用，但需署名作者且注明文章出处。
                    </div>

                </div>
            </div>
        <?php endif; ?>
        <?php if(class_exists('Reward_Plugin') && isset($this->options->plugins['activated']['Reward'])): ?>
            <?php Reward_Plugin::show_reward(); ?>
            <?php Reward_Plugin::show_modal(); ?>
        <?php endif; ?>
    </article>
    

    <?php $this->need('comments.php'); ?>

    <div class="block">
    <ul class="post-near">
        <li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
        <li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
    </ul>
</div>
</div>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
<?php } ?>
