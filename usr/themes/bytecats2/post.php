<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="grid-3-4" id="main" role="main">
    <article class="post">
        <h1 class="post-title ta-c" itemprop="name headline"><?php $this->title() ?></h1>
        <ul class="post-meta ta-c">
            <?php if(!is_mobile()) :?><li itemprop="author"><?php _e('作者: '); ?><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></li><?php endif; ?>
            <li><?php _e('时间: '); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('Y-m-d'); ?></time></li>
            <li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
            <li><span>阅读：<?php $this->views(); ?>次</span></li>
		<li><span class="ds-thread-count" data-thread-key="<?php $this->cid(); ?>"></span></li>
        </ul>
        <div class="post-content" itemprop="articleBody">
            <?php $this->content(); ?>
            
        </div>
       
        <p itemprop="keywords" class="tags"><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></p>
        <?php $this->related(4)->to($relatedPosts); ?>
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

        <div class="related">
            <h3>相关文章推荐</h3>
            <ul class="clearfix">
                <?php while ($relatedPosts->next()): ?>
                <li><a href="<?php $relatedPosts->permalink(); ?>" title="<?php $relatedPosts->title(); ?>"><?php $relatedPosts->title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <ul class="post-near">
            <li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
            <li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
        </ul>
    </article>

    <?php $this->need('comments.php'); ?>

</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
