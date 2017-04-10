<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
	</div><!-- end #main-->
</div><!-- end #body -->
<footer class="footer">
	<div class="footer-inner">
		<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
		<?php if($pages->have()):?>
		<p>
		<?php while($pages->next()): ?>
		<a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
		<?php endwhile; ?>
		</p>
		<?php endif;?>
		<p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>
			<em>·</em> <a href="http://www.typecho.org" target="_blank">Typecho</a>
			<?php if($this->options->icpNum):?> <em>·</em> <a href="http://www.miitbeian.gov.cn/" target="blank"><?php $this->options->icpNum();?></a><?php endif;?>
			<em>·</em> Theme By <a href="http://lixianhua.com/" target="_blank"><?php _e('绛木子'); ?></a>
			<span><?php if($this->options->siteStat):?><?php $this->options->siteStat();?><?php endif;?></span>
		</p>
	</div>
</footer><!-- end #footer -->
</div>
<div class="fixed-btn">
	<a class="btn-gotop" href="javascript:jBlog.goTop();"> <i class="fa fa-angle-up"></i></a>
</div>
<script>
	$(function(){
		jBlog.init({
			url:'<?php $this->options->siteUrl();?>',
			action:'<?php $this->options->index('action');?>',
			current:'<?php echo $this->getArchiveType();?>',
			prefix:'<?php echo md5($this->options->rootUrl);?>',
		});
	});
</script>
<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
<script type="text/javascript">
	var duoshuoQuery = {short_name:"hongweipeng"};
	(function() {
		var ds = document.createElement('script');
		ds.type = 'text/javascript';ds.async = true;
		ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
		ds.charset = 'UTF-8';
		(document.getElementsByTagName('head')[0]
		|| document.getElementsByTagName('body')[0]).appendChild(ds);
	})();
</script>
<!-- 多说公共JS代码 end -->
<script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<?php $this->footer(); ?>
</body>
</html>
