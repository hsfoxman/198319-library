<?php
/**
 * 数据库核心类
 * @author Administrator
 *
 */
class Database_Db_Core extends Database_Model_Core {
	
	/**
	 * @var string 表名
	 */
	protected $_table;
	
	/**
	 * @var obj dbobj
	 */
	protected $_db;
	
	/**
	 * @var string 主键
	 */
	protected $_field = 'id';
	
	/**
	 * @var string 表前缀
	 */
	private $_prefix;
	
	public function __construct() {
		$this->_db = Database_Adodb_Core::getInstance()->get();
		$_config = require APP_PATH . 'config/db.cfg.php';
		$this->_prefix = $_config['prefix'];
	}
	
	/**
	 * 获得数据列表
	 * 
	 * $param = array(
	 * 					'field' => '`id`, `title` ', 
	 * 					'where' => '1 = 1', 
	 * 					'order' => 'id DESC', 
	 * 				)
	 * 
	 * @return array
	 */
	public function getList($params = array()) {	
		$filed = empty($params['field']) ? '*' : $params['field'];
		$where = empty($params['where']) ? ' 1 = 1 ' : $params['where'];
		$order = empty($params['order']) ? ' ORDER BY ' . $this->_table . '_' . $this->_field . ' DESC ' : ' ORDER BY ' . $params['order'];
		$sqlstr = 'select ' . $filed . ' from ' . $this->_prefix . $this->_table . ' WHERE ' . $where . $order;
		return $this->_db->getAll($sqlstr);
	}
	
	/**
	 * 获得数据列表带分页
	 * 
	 * $param = array(
	 * 					'field' => '`id`, `title` ', 
	 * 					'where' => '1 = 1', 
	 * 					'order' => 'id DESC', 
	 * 					'now' => 1, 
	 * 					'limit' => 10, 
	 * 				)
	 * 
	 * @return array
	 */
	public function getListPage($params = array()) {
		$filed = empty($params['field']) ? '*' : $params['field'];
		$where = empty($params['where']) ? ' 1 = 1 ' : $params['where'];
		$order = empty($params['order']) ? ' ORDER BY ' . $this->_table . '_' . $this->_field . ' DESC ' : ' ORDER BY ' . $params['order'];
		$limit = empty($params['limit']) ? 20 : $params['limit'];
		$page = empty($params['now']) ? 1 : $params['now'];
		$sqlstr = $sqlstr = 'select ' . $filed . ' from ' . $this->_prefix . $this->_table . ' WHERE ' . $where . $order;
		$pager = new Database_Page_Core($limit, $page);
		$pager->execute($this->_db, $sqlstr);		
		return $pager;
	}
	
	/**
	 * 获得详细数据
	 * 
	 * @param $id 
	 * $param = array(
	 * 					'field' => '`id`, `title` ', 
	 * 					'where' => 'id = 1',
	 * 					'order' => 'id DESC', 
	 * 					'now' => 1, 
	 * 					'limit' => 10, 
	 * 				)
	 * 
	 * @return array
	 */
	public function getInfo($id, $params = array()) {
		if(empty($id)) {
			return false;
		} 
		$filed = empty($params['field']) ? '*' : $params['field'];
		$where = empty($params['where']) ? $this->_table . '_' . $this->_field . ' = ' . $id : $params['where'];
		$sqlstr = 'SELECT ' . $filed . ' FROM ' . $this->_prefix . $this->_table . ' WHERE ' . $where . ' LIMIT 1';
		return $this->_db->getrow($sqlstr);
	
	}
	
	/**
	 * 插入数据
	 * 
	 * @param array $params
	 * 
	 * @return mix
	 */
	public function insert($params) {
		if(empty($params)) {
			return false;
		}
		foreach($params as $k => $v) {
			$params[$k] = $this->_db->qstr($v);
		}
		$keys = implode(',', array_keys($params));
		$values = implode(',', array_values($params));
		$sqlstr = 'insert into ' . $this->_prefix . $this->_table . ' (' . $keys . ') values (' . $values . ')';
		return $this->_db->execute($sqlstr);
	}

	public function update($params, $where) {
		if(empty($params) || empty($where)) {
			return false;
		}
		if(is_array($params)) {
			$sets = '';
			foreach($params as $k => $v) {
				$sets .= ' `' . $k . '` = ' . $this->_db->qstr($v) . ', ';	
			}
			$sets = substr($sets, 0, -2);
		} else {
			$sets = $params;
		}
		$sqlstr = 'update ' . $this->_prefix . $this->_table . ' set ' . $sets . ' where ' . $where;
		return $this->_db->execute($sqlstr);
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
		$where = empty($params['where']) ? $this->_table . '_' . $this->_field . ' = ' . $id : $params['where'];
		$sqlstr = 'delete from ' . $this->_prefix . $this->_table . ' where ' . $where;
		return $this->_db->execute($sqlstr);
	}
	
	/**
	 * 获得insert_id
	 * 
	 * @return int
	 */
	public function getInsertId() {
		return $this->_db->insert_id();
	}
}