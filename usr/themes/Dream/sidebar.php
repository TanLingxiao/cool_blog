<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?><!-- SIDEBAR -->
<?php //print_r($this); ?>
<div class="sidebar-menu hidden-xs hidden-sm">
	<div class="top-section">
		<div class="profile-image">
			<img src="<?php $this->options->logoUrl() ?>" alt="Volton">
		</div>
		<h3 class="profile-title"><?php $this->options->myname() ?></h3>
		<p class="profile-description"><?php $this->options->mydesc() ?></p>
	</div> <!-- top-section -->
	<div class="main-navigation">
		<ul class="navigation">
            <li><a<?php if($this->is('index')): ?> class="active"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>" title="<?php _e('首页'); ?>"><i class="glyphicon glyphicon-home"></i><?php _e('首页'); ?></a></li>
            <li>
				<a href="javascript:;" title="<?php _e('分类'); ?>"><i class="glyphicon glyphicon-th-large"></i><?php _e('分类'); ?></a>
				<ul>
					<?php $this->widget('Widget_Metas_Category_List')->parse('<li><a href="{permalink}" target="_blank">{name}<div class="label label-warning">{count}</div></a></li>'); ?>
				</ul>
			</li>
			<?php if($this->user->hasLogin()): ?>
				<li><a class="item" href="<?php $this->options->adminUrl(); ?>" target="_blank"><i class="glyphicon glyphicon-user"></i><?php _e('进入后台'); ?></a></li>
				<li><a class="item" href="<?php $this->options->logoutUrl(); ?>"><i class="glyphicon glyphicon-log-out"></i><?php _e('退出'); ?></a></li>
			<?php else: ?>
				<li><a class="item" href="<?php $this->options->adminUrl('login.php'); ?>"><i class="glyphicon glyphicon-log-in"></i><?php _e('登录'); ?></a></li>
			<?php endif; ?>
		</ul>
	</div> <!-- .main-navigation -->
	<div class="animated">
	</div>
</div> <!-- .sidebar-menu -->
