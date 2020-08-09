<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit(0);
/**
 * 反爬虫
 * 
 * @package AntiSpider
 * @author hongweipeng
 * @version 0.0.1
 * @link https://www.hongweipeng.com
 */
class AntiSpider_Plugin implements Typecho_Plugin_Interface {

    public static $v = '0.0.1';
    public static $key = "lXMdrvEz90yXdVo7";
    public static $iv = "DkebZOLIhUKizj2L";

     /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array(__CLASS__, 'encode');
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
     * @return string
     */
    public static function encode( $html, $widget, $lastResult ) {
        $html = empty( $lastResult ) ? $html : $lastResult;
        if (!self::is_content()) {
            return $html;
        }
        $decrypted = preg_replace_callback(
            '#<p>(.*?)</p>#s',
            function ($matches) {
                $encode_text = openssl_encrypt($matches[1], 'aes-128-cbc', static::$key, 0, static::$iv);
                return "<p><script>document.write(crypto_decode('{$encode_text}'))</script></p>";
            },
            $html
        );
        return $decrypted;
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
        $js = Helper::options()->pluginUrl . '/AntiSpider/crypto-js4.0.0.min.js?v=' . self::$v;
        echo "<script src=\"{$js}\"></script>";
        $key = static::split_add_combine(static::$key);
        $iv = static::split_add_combine(static::$iv);
        $js_code =<<<EOF
        <script>
        function crypto_decode(encode_text) {
            if (window.navigator.webdriver) {  // 反 webdriver
                return encode_text;
            }
            let decode = CryptoJS.AES.decrypt(encode_text, CryptoJS.enc.Utf8.parse({$key}), {
                iv: CryptoJS.enc.Utf8.parse({$iv}),
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7
            }).toString(CryptoJS.enc.Utf8);
            return decode;
        }
        </script>
EOF;
        echo $js_code;

    }

    /**
     * 将字符串转成单字节相加的字符串
     * input: 'hello'
     * return: "'h'+'e'+'l'+'l'+'o'"
     * @param $str
     */
    public static function split_add_combine($str) {
        if (!$str) return "''";
        $ret = array_map (function ($val) {
            return "'{$val}'";
        }, str_split($str));

        return implode('+', $ret);
    }

    /**
     *为footer添加js文件
     *@return void
     */
    public static function footer() {
        if (!self::is_content()) {
            return;
        }
    }
}
