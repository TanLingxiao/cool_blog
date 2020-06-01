<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?><div class="side">
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
    <section class="block">
        <p class="ui <?php $this->options->labelColor() ?> ribbon label"><?php _e('最新文章'); ?></p>
        <div class="list">
            <?php $this->widget('Widget_Contents_Post_Recent')->parse('<a href="{permalink}" class="item">{title}</a>'); ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
    <section class="block">
        <p class="ui <?php $this->options->labelColor() ?> ribbon label"><?php _e('最近回复'); ?></p>
        <div class="list ds-recent-comments widget-list" data-num-items="6" data-show-avatars="0" data-show-time="0" data-show-title="0" data-show-admin="1" data-excerpt-length="70"></div>
    </section>
    <?php endif; ?>

    
    
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
    <section class="block">
        <p class="ui <?php $this->options->labelColor() ?> ribbon label"><?php _e('分类'); ?></p>
        <div class="animated list category">
            <?php $this->widget('Widget_Metas_Category_List')->parse('<div class="item"><a href="{permalink}">{name}</a> <div class="ui label">{count}</div></div>'); ?>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowFriend', $this->options->sidebarBlock)): ?>
    <section class="block friend-list">
        <p class="ui <?php $this->options->labelColor() ?> ribbon label">友情链接</p>
        <div class="animated list friend">
            <?php Links_Plugin::output("<a class=\"item\" href=\"{url}\" title=\"{title}\" target=\"_blank\"><img class=\"avatar image\" src=\"{image}\" alt=\"{name}\" /><div class=\"content\"><p class=\"header\">{name}</p><p>{description}</p></div></a>\n", 10); ?>
        </div>
    </section>
    <?php endif; ?>

    <div class="fixsidebar">
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
    <section class="block">
        <p class="ui <?php $this->options->labelColor() ?> ribbon label"><?php _e('归档'); ?></p>
        <div class="animated list">
            <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 m 月')->parse('<a href="{permalink}" class="item">{date}</a>'); ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
    <section class="block">
        <p class="ui <?php $this->options->labelColor() ?> ribbon label"><?php _e('其它'); ?></p>
        <div class="animated list">
            <?php if($this->user->hasLogin()): ?>
            <a class="item" href="<?php $this->options->adminUrl(); ?>" target="_blank"><?php _e('进入后台'); ?> (<?php $this->user->screenName(); ?>)</a>
            <a class="item" href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a>
            <?php else: ?>
            <a class="item" href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a>
            <?php endif; ?>
            <a class="item" href="<?php $this->options->feedUrl(); ?>" target="_blank"><?php _e('文章 RSS'); ?></a>
            <a class="item" href="<?php $this->options->commentsFeedUrl(); ?>" target="_blank"><?php _e('评论 RSS'); ?></a>
            <a class="item" href="http://www.typecho.org" target="_blank">Typecho</a>
        </div>
    </section>
    <?php endif; ?>
    </div>
    <div id="fixed"></div>
</div>
