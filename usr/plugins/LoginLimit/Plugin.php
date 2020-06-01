<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 限制后台登陆失败次数
 * 
 * @package LoginLimit 
 * @author hongweipeng
 * @version 0.9.0
 * @link http://blog.west2online.com
 * @email hongweichen8888@sina.com
 */
class LoginLimit_Plugin implements Typecho_Plugin_Interface {

    public static $halfCount = 0;//到访问时间前半小时内登录失败的次数
     /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        $info = self::login_log_install();
        //插件注册
        Helper::addPanel(3, 'LoginLimit/manage_log.php', '登录日志', '管理登录失败日志', 'administrator');
        Helper::addAction('login_log', 'LoginLimit_Action');
        Typecho_Plugin::factory('Widget_User')->login = array(__CLASS__, 'dologin');
        Typecho_Plugin::factory('Widget_Login')->loginFail = array(__CLASS__, 'loginFail');
    }
    
    /**
     *用户登录操作
     *@return void
     */
    public static function dologin($name, $password, $temporarily, $expire) {

        $time = $_SERVER['REQUEST_TIME'];
        $halfhour = $time - 1800;//半小时前

        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();//获取表前缀

        $select = $db->fetchAll( $db->select('id','add_time')->from($prefix.'loginlog')->where('add_time > ?', $halfhour)->order('add_time', Typecho_Db::SORT_ASC) );
        $limit = self::getLimitCount();
        self::$halfCount = count($select);
        if(count($select) >= $limit) {
            //尝试次数超过允许的设置次数
            $mins = ceil( ($select[0]['add_time'] + 1800 - $time) / 60 );
            self::showErrorMsg('尝试次数超过允许的设置次数,请'.$mins.'分钟后再试');
        }
        
        Typecho_Widget::widget('Widget_Login')->login($name, $password, $temporarily, $expire);
    }
    
    /**
     *用户登录失败
     *@return void
     */
    public static function loginFail($user, $name, $password, $temporarily, $expire) {
        $_SESSION['try_count']++;
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();//获取表前缀
        $data = array(
            'try_username' => $name,
            'try_password' => $password,
            'ip'            => isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:'unknown',
            'add_time'      => $_SERVER['REQUEST_TIME']
            );
        $db->query($db->insert($prefix.'loginlog')->rows($data));
        self::showErrorMsg('无效的账号密码，您还可以尝试'.(self::getLimitCount() - self::$halfCount - 1).'次');
    }

    /**
     *显示错误信息并跳回登录界面
     *@return void
     */
    public static function showErrorMsg($msg) {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'javascript:history.back(-1);';
        Typecho_Widget::widget('Widget_Notice')->set(_t($msg), 'error');
        Typecho_Response::redirect($referer);
    }

    /**
     *获取设置项，半小时允许尝试的登陆次数
     */
    public static function getLimitCount() {
        $limit = Typecho_Widget::widget('Widget_Options')->plugin('LoginLimit')->timetlimit;
        return (int)$limit;
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
        Helper::removePanel(3, 'LoginLimit/manage_log.php');
        Helper::removeAction('login_log');
        //删除登录记录的表格
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();
        try {
            $sql = "drop table ".$prefix.'loginlog';
            $db->query($sql);
        } catch (Typecho_Db_Exception $e) {
            throw new Typecho_Plugin_Exception('删除登录数据表失败');
        }
        return true;
    }

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){

        /** 分类名称 */
        $name = new Typecho_Widget_Helper_Form_Element_Text('timetlimit', NULL, '15', _t('半小时内允许尝试登陆失败的次数'));
        $form->addInput($name);
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    /**
     *初始化数据库
     */
    public static function login_log_install() {
        $installDb = Typecho_Db::get();
        $prefix = $installDb->getPrefix();//获取表前缀
        $script = file_get_contents('usr/plugins/LoginLimit/typecho_loginlog.sql');
        $script = trim(str_replace('typecho_', $prefix, $script));
        try {
            if($script) {
                $installDb->query($script, Typecho_Db::WRITE);
            }
            return '建立登录失败数据表，插件启用成功';
        } catch(Typecho_Db_Exception $e) {
            $code = $e->getCode();
            throw new Typecho_Plugin_Exception('数据表建立失败，插件启用失败。错误号：'.$code);
        }
        return '';
    }
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render() {
        
    }
}
