<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
include_once 'common.php';
include_once 'header.php';
include_once 'menu.php';
?>

<div class="main">
    <div class="body container">
        <?php include 'page-title.php'; ?>
        <div class="row typecho-page-main manage-metas">

                <div class="col-mb-12 col-tb-12" role="main">                  
                    <?php
                    	date_default_timezone_set('PRC');//设置中国时区
                    	$page_size = 20;
                    	$page = isset($_GET['page'])?(int)$_GET['page'] : 1;
						$prefix = $db->getPrefix();
						$all = $db->fetchAll($db->select('id')->from($prefix.'loginlog'));
						$total = count($all);
						$show_logs = $db->fetchAll($db->select()->from($prefix.'loginlog')->order('add_time', Typecho_Db::SORT_DESC)->page($page,$page_size));
						$total_page = ceil(count($all) / $page_size);
                    ?>
                    <form method="post" name="manage_categories" class="operate-form">
                    <div class="typecho-list-operate clearfix">
                        <div class="operate">
                            <label><i class="sr-only"><?php _e('全选'); ?></i><input type="checkbox" class="typecho-table-select-all" /></label>
                            <div class="btn-group btn-drop">
                                <button class="btn dropdown-toggle btn-s" type="button"><i class="sr-only"><?php _e('操作'); ?></i><?php _e('选中项'); ?> <i class="i-caret-down"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a lang="<?php _e('你确认要删除这些记录吗?'); ?>" href="<?php $options->index('/action/login_log?do=deleteLog'); ?>"><?php _e('删除'); ?></a></li>
                                </ul>
                            </div>
                            <label><a id="clear" href="<?php $options->index('/action/login_log?do=clearAll'); ?>"><?php _e('清空数据表'); ?></a></label>
                        </div>
                    </div>

                    <div class="typecho-table-wrap">
                        <table class="typecho-list-table typecho-list-operate">
                            <colgroup>
                                <col width="20"/>
								<col width="25%"/>
								<col width=""/>
								<col width="15%"/>
								<col width="25%"/>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th> </th>
									<th><?php _e('登录用户'); ?></th>
									<th><?php _e('登录密码'); ?></th>
									<th><?php _e('客户端IP'); ?></th>
									<th><?php _e('登录时间'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
								<?php if(!empty($show_logs)): $alt = 0;?>
								<?php foreach ($show_logs as $log): ?>
                                <tr id="lid-<?php echo $log['id']; ?>">
                                    <td><input type="checkbox" value="<?php echo $log['id']; ?>" name="id[]"/></td>
									<td><?php echo htmlspecialchars($log['try_username'], ENT_QUOTES); ?></td>
									<td><?php echo htmlspecialchars($log['try_password'], ENT_QUOTES); ?></td>
									<td><?php echo htmlspecialchars($log['ip'], ENT_QUOTES); ?></td>
									<td><?php echo Typecho_I18n::dateWord($log['add_time'], $_SERVER['REQUEST_TIME']);?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5"><h6 class="typecho-list-table-title"><?php _e('没有任何登录失败的记录'); ?></h6></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php
                        	//分页
                        	$currUrl = ($request->isSecure() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
							parse_str($_SERVER['QUERY_STRING'], $parseUrl);
							unset($parseUrl['page']);
                        	$query = $currUrl.'?'.http_build_query($parseUrl);
							$pange_nav = new Typecho_Widget_Helper_PageNavigator_Box($total, $page, $page_size,$query.'&page={page}');
							echo '<ul class="typecho-pager" style="width:100%;">';
							$pange_nav->render("上一页", "下一页");
							echo '</ul>';
						?>
                    </div>
                    </form>
				</div>
        </div>
    </div>
</div>




<?php 
include 'copyright.php';
include 'common-js.php';
?>
<script type="text/javascript">
(function($){
	//设置全选
	var table = $('.typecho-list-table');
	table.tableSelectable({
            checkEl     :   'input[type=checkbox]',
            rowEl       :   'tr',
            selectAllEl :   '.typecho-table-select-all',
            actionEl    :   '.dropdown-menu a'
        });
	//
	$('.btn-drop').dropdownMenu({
            btnEl       :   '.dropdown-toggle',
            menuEl      :   '.dropdown-menu'
        });
	//清空数据表点击
	$('#clear').on('click',function(e) {
		return confirm("你是否确认清空数据表?");
	});
})(jQuery);
</script>
<?
include 'footer.php'; 
?>