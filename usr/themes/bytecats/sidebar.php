<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<aside class="grid-1-4" id="secondary" role="complementary">
    <section class="widget widget_search">
        <h3>文章搜索</h3>
        <form id="search" method="post" action="./" role="search">

            <input type="text" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
            <button type="submit" class="submit"><?php _e('搜索'); ?></button>
        </form>
    </section>


    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
        <section class="widget widget-category">
            <h3>文章分类</h3>
            <ul class="widget-list">
                <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
                <?php while ($category->next()): ?>
                <li<?php if ($this->is('post')): ?><?php if ($this->category == $category->slug): ?> class="current"<?php endif; ?><?php else: ?><?php if ($this->is('category', $category->slug)): ?> class="current"<?php endif; ?><?php endif; ?>>
                    <a href="<?php $category->permalink(); ?>" title="<?php $category->name(); ?>"><?php $category->name(); ?><em>(<?php $category->count(); ?>)</em></a>
                    <?php endwhile; ?></li>
            </ul>
        </section>
    <?php endif; ?>


    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
    <section class="widget weidget-recent">
		<h3 class="widget-title"><?php _e('最新文章'); ?></h3>
        <ul class="widget-list">
            <?php $this->widget('Widget_Contents_Post_Recent')
            ->parse('<li><a href="{permalink}" title="{title}">{title}</a></li>'); ?>
        </ul>
    </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('归档'); ?></h3>
            <ul class="widget-list">
                <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=F Y')
                    ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('最新评论'); ?></h3>
            <ul class="ds-recent-comments widget-list" data-num-items="10" data-show-avatars="0" data-show-time="0" data-show-title="0" data-show-admin="1" data-excerpt-length="70"></ul>
        </section>
    <?php endif; ?>


    <section class="widget widget-tag">
        <h3>热门标签</h3>
        <div class="tag-cloud">
            <?php $this->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 20))->to($tags); ?>
            <?php while($tags->next()): ?>
                <a rel="tag" href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a>
            <?php endwhile; ?>
        </div>
    </section>
    <!-- 只在首页显示 -->
    <?php if($this->is('index')): ?>
        <section class="widget">
            <h3>友情链接</h3>
            <ul class="widget-list flinks">
                <li><a href="https://www.b1uew01f.net/" target="_blank">B1ueW01f</a></li>
                <li><a href="http://www.hrwhisper.me/" target="_blank">细语呢喃</a></li>
                <li><a href="http://shixiong.name/" target="_blank">Daemon</a></li>
            </ul>
        </section>
    <?php else: ?>
    <?php endif; ?>

</aside><!-- end #sidebar -->
