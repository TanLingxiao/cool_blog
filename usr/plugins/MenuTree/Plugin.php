<?php
/**
 * 文章目录树
 * 
 * @package MenuTree 
 * @author hongweipeng
 * @version 0.6.1
 * @link https://www.hongweipeng.com
 */
class MenuTree_Plugin implements Typecho_Plugin_Interface {
    /**
     * 索引ID
     */
    public static $id = 1;
    
    /**
     * 目录树
     */
    public static $tree = array();

     /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array(__CLASS__, 'parse');
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
     * 解析
     * 
     * @access public
     * @param array $matches 解析值
     * @return string
     */
    public static function parseCallback( $match ) {
        $parent = &self::$tree;

        $html = $match[0];
        $n = $match[1];
        $menu = array(
            'num' => $n,
            'title' => trim( strip_tags( $html ) ),
            'id' => 'menu_index_' . self::$id,
            'sub' => array()
        );
        $current = array();
        if( $parent ) {
            $current = &$parent[ count( $parent ) - 1 ];
        }
        // 根
        if( ! $parent || ( isset( $current['num'] ) && $n <= $current['num'] ) ) {
            $parent[] = $menu;
        } else {
            while( is_array( $current[ 'sub' ] ) ) {
                // 父子关系
                if( $current['num'] == $n - 1 ) {
                    $current[ 'sub' ][] = $menu;
                    break;
                }
                // 后代关系，并存在子菜单
                elseif( $current['num'] < $n && $current[ 'sub' ] ) {
                    $current = &$current['sub'][ count( $current['sub'] ) - 1 ];
                }
                // 后代关系，不存在子菜单
                else {
                    for( $i = 0; $i < $n - $current['num']; $i++ ) {
                        $current['sub'][] = array(
                            'num' => $current['num'] + 1,
                            'sub' => array()
                        );
                        $current = &$current['sub'][0];
                    }
                    $current['sub'][] = $menu;
                    break;
                }
            }
        }
        self::$id++;
        return "<span id=\"{$menu['id']}\" name=\"{$menu['id']}\"></span>" . $html;
    }
    
    /**
     * 构建目录树，生成索引
     * 
     * @access public
     * @return string
     */
    public static function buildMenuHtml( $tree, $include = true ) {
        $menuHtml = '';
        foreach( $tree as $menu ) {
            if( ! isset( $menu['id'] ) && $menu['sub'] ) {
                $menuHtml .= self::buildMenuHtml( $menu['sub'], false );
            } elseif( $menu['sub'] ) {
                $menuHtml .= "<li><a data-scroll href=\"#{$menu['id']}\" title=\"{$menu['title']}\">{$menu['title']}</a>" . self::buildMenuHtml( $menu['sub'] ) . "</li>";
            } else {
                $menuHtml .= "<li><a data-scroll href=\"#{$menu['id']}\" title=\"{$menu['title']}\">{$menu['title']}</a></li>";
            }
        }
        if( $include ) {
            $menuHtml = '<ul>' . $menuHtml . '</ul>';
        }
        return $menuHtml;
    }

    /**
     * 判断是否是内容页，避免主页加载插件
     */
    public static function is_content() {
        static $is_content = null;
        if($is_content === null) {
            $widget = Typecho_Widget::widget('Widget_Archive');
            $is_content = !($widget->is('index') || $widget->is('search') || $widget->is('date'));
        }
        return $is_content;
    }
    /**
     * 插件实现方法
     * 
     * @access public
     * @return string
     */
    public static function parse( $html, $widget, $lastResult ) {
        $html = empty( $lastResult ) ? $html : $lastResult;
        if (!self::is_content()) {
            return $html;
        }
        $html = preg_replace_callback( '/<h([1-6])[^>]*>.*?<\/h\1>/s', array( 'MenuTree_Plugin', 'parseCallback' ), $html );
        return $html;
    }

    /**
     *为header添加css文件
     *@return void
     */
    public static function header() {
        if (!self::is_content()) {
            return;
        }
        $cssUrl = Helper::options()->pluginUrl . '/MenuTree/menutree.css';
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
        if (Helper::options()->plugin('MenuTree')->jq_import) {
            echo '<script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>';
        }

        $html = '<div class="in-page-preview-buttons in-page-preview-buttons-full-reader"><ul><li title="内容目录 Ctrl+Alt+O"id="preview-toc-button"class="in-page-button dropdown"><span data-toggle="dropdown"class="dropdown-toggle icon-list"style="color: rgba(102, 128, 153, 0.45);">+</span><div class="dropdown-menu theme pull-right theme-white"id="toc-list"><h3>内容目录</h3><hr><div class="table-of-contents"><div class="toc"><ul><li>'. self::buildMenuHtml( self::$tree ) .'</li></ul></div></div></div></li></ul></div>';
        $js = Helper::options()->pluginUrl . '/MenuTree/dropdown.js';
        echo <<<HTML
            <script src="{$js}"></script>
            <script type="text/javascript">
            jQuery('body').append('$html');
            </script>
HTML;
        self::$id = 1;
        self::$tree = array();

    }
}
