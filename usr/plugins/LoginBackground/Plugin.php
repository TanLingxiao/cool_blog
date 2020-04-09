<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit(0);

/**
 * 后台登录背景图
 * 
 * @package LoginBackground
 * @author hongweipeng
 * @version 0.0.1
 * @link https://www.hongweipeng.com
 */
class LoginBackground_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('admin/header.php')->header = array(__CLASS__, 'render');
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
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** 分类名称 */
//        $gray_dates = new Typecho_Widget_Helper_Form_Element_Textarea('gray_dates', NULL, '', _t('变灰日期'), _t('填入形如"04-04" 或 "2020-04-04"日期，一行一个，不指定年份表示每年'));
//        $form->addInput($gray_dates);
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    public static function getBackgroundImagePath() {
        $now_hour = (int) (time() / 3600);
        $filenames = array_map('basename', glob(__TYPECHO_ROOT_DIR__ . __TYPECHO_PLUGIN_DIR__ . '/LoginBackground/bg/*'));
        $image_url = Helper::options()->pluginUrl . '/LoginBackground/bg/' . $filenames[$now_hour % count($filenames)];
        return $image_url;
    }

    /**
     * 插件实现方法
     * 
     * @access public
     * @return string
     */
    public static function render($header)
    {
        if (Typecho_Widget::widget('Widget_User')->hasLogin()) {
            return $header;
        }
        $logo_path = Helper::options()->pluginUrl . '/LoginBackground/logo/typecho-logo-dark.png';
        $gb_path = static::getBackgroundImagePath();
        $style =<<<EOF
    <style>
    body {
        font-family: roboto, sans-serif;
        text-align: center;
        background-image: url('{$gb_path}');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
    }
    
    .typecho-login {
        background: rgba(255, 255, 255, 0.68);
        display: block;
        padding: 10px 20px;
        border-radius: 5px;
        margin-top: 20vh;
        -moz-box-shadow: 0 0 10px #ffffff;
        box-shadow: 0 0 10px #ffffff;
    }
    
    .primary {
        background-color: #6b91c0; /*按钮颜色重写*/
    }
    
    .primary:hover {
        background-color: #a1bee0; /*按钮hover颜色重写*/
    }
    
    .typecho-login .more-link {
        margin-top: 0;
        color: #bbb;
    }
    
    .typecho-login h1 {
        margin: 10px 0 0;
    }
    
    .i-logo, .i-logo-s {
        width: 228px;
        height: 36px;
        opacity: 0.7;
        background: url('{$logo_path}') no-repeat;
    }
    </style>
EOF;
        return $header . $style;
    }

}
