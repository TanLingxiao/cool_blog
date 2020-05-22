<?php
/**
 * 说说，点滴记录
 * 
 * @package MicroTalk
 * @author hongweipeng
 * @version 0.0.1
 * @link https://www.hongweipeng.com
 *
 */
class MicroTalk_Plugin implements Typecho_Plugin_Interface
{

    public static $DIR_NAME = 'MicroTalk';  // 文件夹名称
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
		$info = static::install();
		Helper::addPanel(3, static::$DIR_NAME . '/manage-talk.php', '管理说说', '管理说说', 'administrator');
		Helper::addAction('MicroTalk-edit', 'MicroTalk_Action');
		_t($info);
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
	{
		Helper::removeAction('MicroTalk-edit');
		Helper::removePanel(3, static::$DIR_NAME . '/manage-talk.php');
        //删除登录记录的表格
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();
        try {
            //$sql = "drop table ".$prefix.'domaintheme';
            //$db->query($sql);
        } catch (Typecho_Db_Exception $e) {
            throw new Typecho_Plugin_Exception('删除登录数据表失败');
        }
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form) {}
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

	public static function install()
	{
		$installDb = Typecho_Db::get();
        $type = explode('_', $installDb->getAdapterName());
        $type = array_pop($type);
        $prefix = $installDb->getPrefix();//获取表前缀
        $script = file_get_contents('usr/plugins/MicroTalk/typecho_talk.sql');
        $script = trim(str_replace('typecho_', $prefix, $script));
        $script = str_replace('%charset%', 'utf8', $script);
        try {
            if($script) {
                $installDb->query($script, Typecho_Db::WRITE);
            }
            return '建立数据表，插件启用成功';
        } catch(Typecho_Db_Exception $e) {
            $code = $e->getCode();
            if(('Mysql' == $type && 1050 == $code) || ($code == '42S01') ||
                ('SQLite' == $type && ('HY000' == $code || 1 == $code))) {
                return '检测到数据表已存在，插件启用成功';
            }
            throw new Typecho_Plugin_Exception('数据表建立失败，插件启用失败。错误号：'.$code);
        }
	}

	public static function form($action = NULL)
	{
        $request = Typecho_Request::getInstance();
		/** 构建表格 */
		$options = Typecho_Widget::widget('Widget_Options');

		$form = new Typecho_Widget_Helper_Form(Typecho_Common::url('/action/MicroTalk-edit', $options->index),
		Typecho_Widget_Helper_Form::POST_METHOD);

        /** 链接主键 */
        $id = new Typecho_Widget_Helper_Form_Element_Hidden('id');
        $form->addInput($id);

        $content =  new Typecho_Widget_Helper_Form_Element_Textarea('content', NULL, NULL, _t('说说内容(支持markdown)'));
        $form->addInput($content);

        $is_show = new Typecho_Widget_Helper_Form_Element_Radio('isShow',
            array('0'=>_t('隐藏'), '1'=>_t('显示'),), '1', _t('是否显示'), _t(''));
        $form->addInput($is_show);

        $created = new Typecho_Widget_Helper_Form_Element_Text('created', NULL, NULL, _t('创建时间'));
        $form->addInput($created);

        /** 动作 */
        $do = new Typecho_Widget_Helper_Form_Element_Hidden('do');
        $form->addInput($do);

        /** 提交按钮 */
        $submit = new Typecho_Widget_Helper_Form_Element_Submit();
        $submit->input->setAttribute('class', 'btn primary');

        if (isset($request->id) && 'insert' != $action) {
            /** 更新模式 */
			$db = Typecho_Db::get();
            $talk = $db->fetchRow($db->select()->from('table.talk')->where('id = ?', $request->id));
            if (!$talk) {
                throw new Typecho_Widget_Exception(_t('说说不存在'), 404);
            }
            $id->value($talk['id']);
            $content->value($talk['content']);
            $is_show->value($talk['isShow']);
            $created->value($talk['created']);
            $do->value('update');

            $submit->value(_t('编辑'));
            $_action = 'update';
        } else {
            $do->value('insert');
            $submit->value(_t('增加'));
            $_action = 'insert';
        }

        if (empty($action)) {
            $action = $_action;
        }

        /** 给表单增加规则 */
        if ('insert' == $action || 'update' == $action) {
            $content->addRule('required', _t('必须填写内容'));
        }
        if ('update' == $action) {
            $id->addRule('required', _t('主键不存在'));
        }

        $form->addItem($submit);
        return $form;
	}

    /**
     * 获得说说总数
     * @return int
     */
	public static function totalShowCount() {
        $db = Typecho_Db::get();
        $count = $db->fetchRow($db->select('count(1) as total_num')->from('table.talk')->where('isShow = ?', 1));
        $total = $count['total_num'];
        return $total;
    }

	public static function talkPosts($page=1, $page_size=20) {
        $db = Typecho_Db::get();
        $select = $db->select('table.talk.*', 'users.screenName as author', 'users.mail as mail')->from('table.talk')
            ->where('table.talk.isShow = ?', 1)
            ->join('table.users as users', 'table.talk.authorId = users.uid', Typecho_Db::LEFT_JOIN)
            ->order('table.talk.created', Typecho_Db::SORT_DESC)
            ->page($page,$page_size);

        $talks = $db->fetchAll($select);
        foreach ($talks as &$talk) {
            $talk['content'] = static::markdown($talk['content']);
        }
        return $talks;
    }

    public static function markdown($text) {
        $html = Markdown::convert($text);
        return $html;
    }

}
