<?php

class TEWeiYu_Reply extends Widget_Abstract {
    private $_themeDir;
    private $_themeFile;
    private $_id;
    private $__themeFile;
    private $_wyItem;

    public function __construct($request, $response, $params = NULL) {
        parent::__construct($request, $response, $params);
        //$this->options = $this->widget("Widget_Options");
        $this->_themeDir =  __TYPECHO_ROOT_DIR__ . '/' . __TYPECHO_THEME_DIR__ . '/' . $this->options->theme . '/';
        $this->_themeFile = 'wyreply_tmpl.php';
        $this->_id =$this->request->msgId;
        $themeFile = $this->_themeDir . $this->_themeFile;
        if (! file_exists($themeFile)) {
            $pluginDir = dirname(__FILE__);
            copy($pluginDir.DIRECTORY_SEPARATOR."wyreply_tmpl.php", $themeFile);
            if (! file_exists($themeFile)) {
                //echo "no tmpl file";
                Typecho_Common::error(404);
                return;
            }
        }

        $this->_wyItem = $this->widget("TEWeiYu_Action")->getMsgByIndex($this->_id);
        if ($this->_wyItem == null) {
            Typecho_Common::error(404);
            //echo "no WY item";
            return;
        }
    }

    public function render() {
        $this->response->setHeader('X-Pingback', $this->options->xmlRpcUrl);
        /** 输出模板 */
        require_once $this->_themeDir . $this->_themeFile;
    }

    public function title() {
        echo $this->_wyItem->msg;
    }

    public function msgId() {
        echo $this->_id;
    }

    public function content() {
        echo "Content Me";
    }

    public function select() {}
    public function size(Typecho_Db_Query $condition) {}
    public function insert(array $rows) {}
    public function update(array $rows, Typecho_Db_Query $condition) {}
    public function delete(Typecho_Db_Query $condition) {}

    /**
     * 获取主题文件
     *
     * @access public
     * @param string $fileName 主题文件
     * @return void
     */
    public function need($fileName)
    {
        require __TYPECHO_ROOT_DIR__ . '/' . __TYPECHO_THEME_DIR__ . '/' . $this->options->theme . '/' . $fileName;
    }
}

?>