<?php
/**
 * 加载类
 * 
 * @author fox_hu
 *
 */
class Loader_Loader_Core {
	
	/**
	 * 类加载方法
	 * 
	 * @param string $classname
	 * 
	 * @return void
	 */
	static function loadClass($classname) {
		$classname = strtolower($classname);
		//smarty loader
		if (substr($classname, 0, 6) === 'smarty') {
			include SMARTY_SYSPLUGINS_DIR . $classname . '.php';
		} else if(substr($classname, 0, 4) === 'zend' || substr($classname, 0, 5) === 'zendx') {
			require_once 'Zend/Loader/Autoloader.php';
			Zend_Loader_Autoloader::getInstance();
		} else {
		//core loader
			$obj = explode('_', $classname);
			$classCode = end($obj);
			reset($obj);
			array_pop($obj);	
			$classCfg = include CORE_PATH . 'config/class.cfg.php';
			$path = '';
			if (!empty($obj)) {
				foreach ($obj as $val) {
					$path .= $val . '/';
				}
			}	
			$classPath = $classCfg[$classCode] . substr($path, 0, -1) . '.php';
			if(!empty($classname) && file_exists($classPath)) {
				include_once($classPath);
			} 
		}		
	}
}