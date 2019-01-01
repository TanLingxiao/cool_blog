<?php
/**
 * 打赏
 * 
 * @package Reward
 * @author hongweipeng
 * @version 0.7.0
 * @link https://www.hongweipeng.com
 */
class Reward_Plugin implements Typecho_Plugin_Interface {

    static $v = '0.7.0';

     /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Typecho_Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){

        $jq_import = new Typecho_Widget_Helper_Form_Element_Radio('jq_import', array(
            0   =>  _t('不引入'),
            1   =>  _t('引入')
        ), 1, _t('是否引入jQuery'), _t('此插件需要jQuery，如已有选择不引入避免引入多余jQuery'));
        $form->addInput($jq_import->addRule('enum', _t('必须选择一个模式'), array(0, 1)));
        $default_pay = new Typecho_Widget_Helper_Form_Element_Text('default_pay', NULL, 'https://www.hongweipeng.com/usr/uploads/2016/09/555702225.jpg', _t('默认的二维码'), _t('该项用于用户自定义数据扩展'));
        $form->addInput($default_pay);

        $user = new Typecho_Widget_Helper_Form_Element_Textarea('authors', NULL, NULL, _t('打赏二维码信息'), _t('输入合法的json数据'));
        $form->addInput($user);

    }

    static function reward_img($author_name) {
        $_map = Helper::options()->plugin('Reward')->authors;
        $_map = json_decode($_map, true);
        return isset($_map[$author_name]) ? $_map[$author_name] : Helper::options()->plugin('Reward')->default_pay;
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
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render() {
        
    }



    /**
     * 判断是否是内容页，避免主页加载插件
     */
    public static function is_content() {
        static $is_content = null;
        if($is_content === null) {
            $widget = Typecho_Widget::widget('Widget_Archive');
            $is_content = !($widget->is('index') || $widget->is('search') || $widget->is('date') || $widget->is('category') || $widget->is('author'));
        }
        return $is_content;
    }

    /**
     *为header添加css文件
     *@return void
     */
    public static function header() {
        if (!self::is_content()) {
            return;
        }
        $cssUrl = Helper::options()->pluginUrl . '/Reward/reward.css?v=' . self::$v;
        echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
    }

    /**
     *为footer添加js文件
     *@return void
     */
    public static function footer() {
        if (!self::is_content()) {
            return;
        }
        if (Helper::options()->plugin('Reward')->jq_import) {
            echo '<script src="//cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>';
        }
        $jsUrl = Helper::options()->pluginUrl . '/Reward/modal.js?v=' . self::$v;
        echo '<script src="'.$jsUrl.'"></script>';



    }
    
    public static function show_reward($extra_str='') {
        static $words = array(
            "如果对您有用，您的支持将鼓励我继续创作！",
            "赏个馒头吧",
        );
        $word = $words[array_rand($words)];
        $html = <<<HTML
        <div class="support-author">
            <p>{$word}</p>
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#pay-modal">￥ 打赏</button>
            $extra_str
        </div>
HTML;
        echo $html;

    }

    public static function show_modal() {

        $author_name = Typecho_Widget::widget('Widget_Archive')->author->screenName;
        $pay_img = self::reward_img($author_name);
        $html = <<<HTML
<div class="modal fade" id="pay-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">谢谢您的支持</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                    <img src="{$pay_img}" alt="" style="border-radius: 0.5rem" />
            </div>
        </div>
    </div>
</div>
HTML;
        echo $html;

    }
}
