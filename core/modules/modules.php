<?php 
/**
 * 模型类抽象类
 * 
 * @author fox_hu
 *
 */
abstract class Modules_Modules_Core {
	
	/**
	 * @var $_cacheSwitch 是否使用缓存
	 */
	protected $_cacheSwitch;
	
	/**
	 * @var $_cacheObj 缓存obj
	 */
	protected $_cacheObj;
	
	/**
	 * @var $_modName 模型名
	 */
	protected $_modName;
	
	public function __construct() {
		//获取缓存
		$_site  = require APP_CFG_PATH . 'site.cfg.php';
		$this->_cacheSwitch = empty($_site['cache_switch']) ? false : $_site['cache_switch'];
		if (true === $this->_cacheSwitch) {
			if (!Zend_Registry::isRegistered('cache')) {
				$cacheCore = new Cache_Cache_Core();
				Zend_Registry::set('cache', $cacheCore->get());
			}
			$this->_cacheObj = Zend_Registry::get('cache');
		}
	
	}
	
	/**
	 * 获取列表值
	 * 
	 * @param $params
	 * 
	 * @return  array
	 */
	public function getList($params = array()) {
		if (true === $this->_cacheSwitch && !empty($this->_cacheObj)) {
			$_cacheKey = $this->_modName;
			if(!$_result = $this->_cacheObj->load($_cacheKey)) {
				$_result = $this->_getList($params);
				$this->_cacheObj->save($_result, $_cacheKey);			
			}  
			return $_result;
		} else {
			return $this->_getList($params);
		}		
	}
	
/**
	 * 获取列表值
	 * 
	 * @param $params
	 * 
	 * @return  array
	 */
	public function getListPage($params = array()) {
		if (true === $this->_cacheSwitch && !empty($this->_cacheObj)) {
			$_cacheKey = $this->_modName . 'page' . $param['now'];
			if(!$_result = $this->_cacheObj->load($_cacheKey)) {
				$_result = $this->_getList($params);
				$this->_cacheObj->save($_result, $_cacheKey);			
			}  
			return $_result;
		} else {
			return $this->_getListPage($params);
		}		
	}
	
	/**
	 * 获取详细信息
	 * 
	 * @param $params
	 * 
	 * @retrun array
	 */
	public function getInfo($id, $params = array()) {
		if (!empty($id)) {
			if (true === $this->_cacheSwitch && !empty($this->_cacheObj)) {
				$_cacheKey = $this->_modName . $id;
				if(!$_result = $this->_cacheObj->load($_cacheKey)) {
					$_result = $this->_getInfo($id, $params);
					$this->_cacheObj->save($_result, $_cacheKey);			
				}  
				return $_result;
			} else {
				return $this->_getInfo($id, $params);
			}
		}		
	}
	
	/**
	 * 添加数据
	 * 
	 * @param array $params
	 * 
	 * @return mix
	 */
	public function insert($params) {
		if (empty($params)) {
			return false;
		}
		$name = ucfirst($this->_modName) . '_Dao';
		$dao = new $name;
		if ($dao->insert($params)) {
			return $dao->getInsertId();
		} else {
			return false;
		}	
	}
	
	/**
	 * 删除数据
	 * 
	 * @param int $id 
	 * @param array $params
	 * 
	 * @return mix
	 */
	public function delete($id, $params = array()) {
		if (empty($id)) {
			return false;
		}
		$name = ucfirst($this->_modName) . '_Dao';
		$dao = new $name;
		return $dao->delete($id, $params);	
	}
	
	/**
	 * 修改数据
	 * 
	 * @param array $params 修改内容
	 * @param string $where 条件
	 * 
	 * @return mix
	 */
	public function update($params, $where) {
		if(empty($params) || empty($where)) {
			return false;
		}
		$name = ucfirst($this->_modName) . '_Dao';
		$dao = new $name;
		return $dao->update($params, $where);	
	}
	
	
	/**
	 * 通过数据库获取列表值
	 * 
	 * @param unknown_type $params
	 * 
	 * @return mix
	 */
	protected function _getList($params = array()) {
		$name = ucfirst($this->_modName) . '_Dao';
		$dao = new $name;
		return $dao->getList($params);
	}
	
	/**
	 * 通过数据库获取列表值
	 * 
	 * @param unknown_type $params
	 * 
	 * @return mix
	 */
	protected function _getListPage($params = array()) {
		$name = ucfirst($this->_modName) . '_Dao';
		$dao = new $name;
		return $dao->getListPage($params);
	}
	
	/**
	 * 通过数据库获取详细信息
	 * 
	 * @param int $id
	 * 
	 * @return mix
	 */
	protected function _getInfo($id, $params = array()) {
		$name = ucfirst($this->_modName) . '_Dao';
		$dao = new $name;
		return $dao->getInfo($id, $params);	
	}
}
