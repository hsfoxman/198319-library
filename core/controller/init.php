<?php
/**
 * 
 * 站点初始化抽象类
 *
 */
abstract class Controller_Init_Core {
	
	/**
	 * smartyClass
	 */
	private $_smarty;
	
	public function __construct() {
		$this->_initSmarty();
		$this->_initAssign();
	}
	
	/**
	 * 初始化smarty相关
	 */
	private function _initSmarty() {
		include SMARTY_PATH . 'Smarty.class.php';
		$this->_smarty = new smarty();
		$this->_smarty->template_dir = APP_PATH . 'view/';
		$this->_smarty->compile_dir = APP_PATH . 'cache/view/';
		$this->_smarty->config_dir = APP_PATH . 'configs/';
		$this->_smarty->cache_dir = APP_PATH . 'cache/';
		$this->_smarty->plugins_dir = array_merge($this->_smarty->plugins_dir, array(APP_PATH . 'plugins'));
		$this->_smarty->left_delimiter = '{';
		$this->_smarty->right_delimiter = '}';
	}
	
	/**
	 * 赋予站点初始值
	 */
	private function _initAssign() {
		$site  = require APP_CFG_PATH . 'site.cfg.php';
		$this->assign('SITE_TITLE', $site['site_title']);
		$this->assign('SITE_TPL_PATH', SITE_TPL_PATH);
		$this->assign('SITE_CHARSET', $site['site_charset']);
		$this->assign('SITE_KEYWORDS', $site['site_keywords']);
		$this->assign('SITE_DESCRIPTION', $site['site_description']);
		$this->assign('SITE_URL', $site['site_url']);	
		$this->assign('JS_PATH', $site['js_url'] . $site['js_code'] . $site['site_code']);	
		$this->assign('CSS_PATH', $site['css_url'] . $site['css_code'] . $site['site_code']);	
		$this->assign('ADMIN_TPL_PATH', ADMIN_TPL_PATH);
		$this->assign('ADMIN_JS_PATH', $site['js_url'] . 'admin/' . $site['site_code']);	
		$this->assign('ADMIN_CSS_PATH', $site['css_url'] . 'admin/' . $site['site_code']);
		$this->assign('ADMIN_IMG_PATH', $site['css_url'] . 'admin/' . $site['site_code'] . 'img/');	
		$this->assign('ADMIN_JS_COM_PATH', $site['js_url'] . 'admin/common/');
		$this->assign('ADMIN_CSS_COM_PATH', $site['css_url'] . 'admin/common/');
		$this->assign('ADMIN_IMG_COM_PATH', $site['css_url'] . 'admin/common/img/');	
		$this->assign('RESOURCE_PATH', $site['resource_url']);		
	}
	
	/**
	 * 设置模板值
	 * 
	 * @param string $tplVar
	 * @param string $value
	 * 
	 * @return void
	 */
	public function assign($tplVar, $value = null) {
		$this->_smarty->assign($tplVar, $value);
	}
	
	/**
	 * 显示页面
	 * 
	 * @param string $template 调用的模板
	 * @param srting $mainPage 显示页面
	 * 
	 * @return void
	 */
	public function display($mainPage, $template = 'default') {
		$this->assign('ADMIN_TPL_PATH', ADMIN_TPL_PATH);
		$this->assign('main', $template . '/' . $mainPage . '.tpl');
		$this->_smarty->display($template . '/layout.tpl');
	}
	
	/**
	 * 显示后台页面
	 * 
	 * @param string $template 调用的模板
	 * @param srting $mainPage 显示页面
	 * 
	 * @return void
	 */
	public function displayAdmin($mainPage) {
		$this->display($mainPage, 'admin');
	}

}