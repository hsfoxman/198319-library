<?php
/**
 * 数据库模型类
 * @author fox_hu
 *
 */
abstract class Database_Model_Core {
	abstract function getList($params = '');
	abstract function getInfo($id, $params = '');
	abstract function insert($params);
	abstract function update($params, $where);
	abstract function delete($id, $params = '');
}