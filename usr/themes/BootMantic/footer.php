    </div>
</div>

<footer>
    <div class="container">
        <p>
            &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
            <?php _e('All Rights Reserved. 版权所有.'); ?>
            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1257015934'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1257015934%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>       
            <!--   百度统计 start -->        
            <script type="text/javascript">       
            var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");        
            document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Ffb82a04cc28d2e2a378835c0caecfa3e' type='text/javascript'%3E%3C/script%3E"));     
            </script>     
            <!-- 百度统计 end -->
        </p>
    </div>
</footer>
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
<script src="<?php $this->options->themeUrl('js/script.js'); ?>"></script>
    </body>
</html>
