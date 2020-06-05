<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
include 'header.php';
include 'menu.php';

$post = new stdClass();
$post->isMarkdown = 1;
$post->cid = (int) $request->get('id', 0);
?>
<style>
    .dynamic-list-item {
        /*border-top: 1px #e4dad1 solid; */
        /*border-bottom: 1px #e4dad1 solid;*/
        font-size: 18px;
        background-color: #fff;
        cursor: pointer;
    }
    .dynamic-list-item:hover {
        background-color: #F6F6F3;
    }

    .dynamic-list-item.active {
        background-color: rgba(94, 169, 169, 0.17);
    }

    .dynamic-list-item div.title {

    }

    .dynamic-list-item div.subtitle {
        font-size: 10px;
        margin-top: 3px;
        color: #827C7C;
    }

    .dynamic-list-item div.subtitle .time {
        float: right;
    }
</style>

<div class="main">
    <div class="body container">
        <?php include 'page-title.php'; ?>
        <div class="row typecho-page-main manage-metas">
                <div class="col-mb-12">
                    <ul class="typecho-option-tabs clearfix">
                        <li class="current"><?php _e('点击名称进入编辑'); ?></li>
                    </ul>
                </div>
                <div class="col-mb-4" role="main">
                    <?php
                        $user = Typecho_Widget::widget('Widget_User');
                        $page_size = 20;
                        $page = (int) $request->get('page', 1);
                        $count = $db->fetchRow($db->select('count(1) as total_num')->from('table.talk')->where('authorId = ?', $user->uid));
                        $total = $count['total_num'];
                        $talks = $db->fetchAll($db->select()->from('table.talk')
                            ->where('authorId = ?', $user->uid)
                            ->order('created', Typecho_Db::SORT_DESC)
                            ->page($page,$page_size));
                        $total_page = ceil($total / $page_size);
                    ?>
                    <form method="post" name="manage_categories" class="operate-form">
                    <div class="typecho-list-operate clearfix">
                        <div class="operate">
                            <label><i class="sr-only"><?php _e('全选'); ?></i><input type="checkbox" class="typecho-table-select-all" /></label>
                            <div class="btn-group btn-drop">
                                <button class="btn dropdown-toggle btn-s" type="button"><i class="sr-only"><?php _e('操作'); ?></i><?php _e('选中项'); ?> <i class="i-caret-down"></i></button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a lang="<?php _e('你确认要删除这些记录吗?'); ?>" href="<?php $options->index('/action/MicroTalk-edit?do=delete'); ?>">
                                            <?php _e('删除'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="typecho-table-wrap">
                        <table class="typecho-list-table">
                            <colgroup>
                                <col width="20"/>
                                <col width=""/>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th> </th>
									<th><?php _e('我的说说'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
								<?php if(!empty($talks)): $alt = 0;?>
								<?php foreach ($talks as $talk): ?>
                                <tr id="lid-<?php echo $talk['id']; ?>">
                                    <td><input type="checkbox" value="<?php echo $talk['id']; ?>" name="id[]"/></td>
									<td>
                                        <div class="dynamic-list-item" data-id="5">
                                            <div class="title">
                                                <a href="<?php echo $request->makeUriByRequest('id=' . $talk['id']); ?>" title="点击编辑">
                                                <?php echo htmlspecialchars(Typecho_Common::subStr($talk['content'], 0, 30), ENT_QUOTES); ?>
                                                </a>
                                            </div>
                                            <div class="subtitle">
                                                <span class="author">hongweipeng</span>
                                                <span class="time">
                                                    <span><?php _e($talk['isShow'] ? '' : '[隐藏]'); ?></span>
                                                    <?php echo date('Y-m-d H:i:s', $talk['created']); ?>
                                                </span>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="4"><h6 class="typecho-list-table-title"><?php _e('没有任何数据'); ?></h6></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php
                            //分页
                            $query = $request->makeUriByRequest('page={page}');
                            $pange_nav = new Typecho_Widget_Helper_PageNavigator_Box($total, $page, $page_size, $query);
                            echo '<ul class="typecho-pager" style="width:100%;">';
                            $pange_nav->render("上一页", "下一页");
                            echo '</ul>';
                        ?>
                    </div>
                    </form>
				</div>
                <div class="col-mb-8" role="form">
                    <?php MicroTalk_Plugin::form()->render(); ?>
                    <div id="tab-files" class="tab-content">
                        <?php include 'file-upload.php'; ?>
                    </div>
                </div>
        </div>
    </div>
</div>

<?php
include 'copyright.php';
include 'common-js.php';
include 'editor-js.php';
include 'file-upload-js.php';
?>

<script type="text/javascript">
(function () {
    $(document).ready(function () {
        $('#tab-files').trigger('init');
        var table = $('.typecho-list-table');

        table.tableSelectable({
            checkEl     :   'input[type=checkbox]',
            rowEl       :   'tr',
            selectAllEl :   '.typecho-table-select-all',
            actionEl    :   '.dropdown-menu a'
        });

        $('.btn-drop').dropdownMenu({
            btnEl       :   '.dropdown-toggle',
            menuEl      :   '.dropdown-menu'
        });

        $('.dropdown-menu button.merge').click(function () {
            var btn = $(this);
            btn.parents('form').attr('action', btn.attr('rel')).submit();
        });

        <?php if (isset($request->id)): ?>
        $('.typecho-mini-panel').effect('highlight', '#AACB36');
        <?php endif; ?>
    });
})();
</script>
<?php include 'footer.php'; ?>
