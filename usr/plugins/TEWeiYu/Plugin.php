<?php
/**
 * 微语 for typecho
 * 
 * @package TEWeiYu 
 * @author arest
 * @version 1.0.0
 * @link http://www.blog.kgsoft.cn
 */
class TEWeiYu_Plugin implements Typecho_Plugin_Interface
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
        //$menuIndex = Helper::addMenu(_t("微语"));
        Helper::addPanel(1, "TEWeiYu/MainView.php", _t("微语"), _t("微语"), 'administrator');
        Helper::addAction('weiyu-add', 'TEWeiYu_Action');
        Helper::addRoute('wyreply_page', '/wyreply/[msgId:string]', 'TEWeiYu_Reply', 'render', 'index_page');
        //Typecho_Plugin::factory('admin/menu.php')->navBar = array('TEWeiYu_Plugin', 'render');
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
        //$menuIndex = Helper::removeMenu("TestMenu");
        Helper::removeRoute('wyreply_page');
        Helper::removeAction('weiyu-add');
        Helper::removePanel(1, "TEWeiYu/MainView.php");
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
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render() {}
}
