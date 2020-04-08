<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit(0);

/**
 * 整站变灰 
 * 
 * @package SiteGray
 * @author hongweipeng
 * @version 0.0.1
 * @link https://www.hongweipeng.com
 */
class SiteGray_Plugin implements Typecho_Plugin_Interface
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
        Typecho_Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'header');
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
        $gray_dates = new Typecho_Widget_Helper_Form_Element_Textarea('gray_dates', NULL, '', _t('变灰日期'), _t('填入形如"04-04" 或 "2020-04-04"日期，一行一个，不指定年份表示每年'));
        $form->addInput($gray_dates);
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
    public static function header()
    {
        $gray_dates=Typecho_Widget::widget('Widget_Options')->plugin('SiteGray')->gray_dates;
        $date_arr = explode("\n", $gray_dates );
        if (static::match($date_arr)) {
            $cssUrl = Helper::options()->pluginUrl . '/SiteGray/site_gray.css';
            echo '<meta name="theme-color" content="999999">';
            echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
        }
    }

    public static function match($date_arr) {
        $today1 = date('Y-m-d');
        $today2 = date('m-d');
        foreach ($date_arr as $date) {
            $date = trim($date);
            if ($date == $today1 || $date == $today2) {
                return true;
            }
        }
        return false;
    }

}
