<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div><!-- end .row -->
    </div>
</div><!-- end #body -->
<div id="goTop" class="<?php if(is_mobile()) {echo 'mbtop';}?>" >
	<div class="arrow"></div>
	<div class="stick"></div>
</div>
<script src="<?php $this->options->themeUrl('js/waves.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/jquery.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/jquery.appear.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/script.js'); ?>"></script>

<footer id="footer" class="<?php if(is_mobile()) {echo 'mbfoot';}?>" role="contentinfo">
    Copyright&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1257015934'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1257015934%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
 
 <!--   百度统计 start -->
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Ffb82a04cc28d2e2a378835c0caecfa3e' type='text/javascript'%3E%3C/script%3E"));
</script>
<!-- 百度统计 end -->
</footer><!-- end #footer -->
<?php $this->footer(); ?>
<script type="text/javascript">
	// material design 图标点击效果
	  Waves.displayEffect();
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
</body>
</html>
