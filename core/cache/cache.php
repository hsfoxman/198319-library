<?php
/**
 * 缓存类
 * 
 * @author fox_hu
 *
 */
class Cache_Cache_Core {

	/**
	 * @var 缓存存放目录
	 */
	private $_cacheDir;
	
	/**
	 * @var 缓存时间
	 */
	private $_lifeTime;
	
	/**
	 * @var 缓存 obj
	 */
	private static $_cache;
	
	public function __construct() {
		if (empty($this->_cache)) {
			$this->_init();
			$_frontendOptions = array(
			   'lifeTime' => $this->_lifeTime,
				'automatic_serialization' => true
			);
			$_backendOptions = array(
			    'cache_dir' => $this->_cacheDir
			);
			$this->_cache = Zend_Cache::factory('Core', 
			                             'File', 
			                             $_frontendOptions, 
			                             $_backendOptions);
		}
	}
	
	public function get() {
		if (!empty($this->_cache)) {
			return $this->_cache;
		}
	}
	/**
	 * 设置初始值
	 * 
	 * @return void
	 */
	private function _init() {
		$this->setLifeTime();	
		$this->setCacheDir();	
	}
	
	/**
	 * 设置缓存存活时间
	 * 
	 * @param int $time
	 * 
	 * @return void
	 */
	public function setLifeTime($time = 7200) {
		if (!empty($time) && is_int($time)) {
			$this->_lifeTime = $time;
		}
	}
	
	/**
	 * 设置缓存存放目录
	 * 
	 * @param string $filePath
	 * 
	 * @return void
	 */
	public function setCacheDir($filePath = 'cache/file/') {
		if (!empty($filePath) && is_string($filePath)) {
			$this->_cacheDir = APP_PATH . $filePath;
		}
	}
	
	
}