<?php 
/**
 * ADODB抽象类
 * @author fox_hu
 *
 */
class Database_Adodb_Core {
	
	/**
	 * @var string  dbObj
	 */
	private $_db;
	
	private static $_instance;
	
	private function __construct() {
		//empty
	}
	
	/**
	 * 单列模式
	 */
	public static function &getInstance() {
        if (!self::$_instance) {
            self::$_instance = new Database_Adodb_Core();      	
        }
        return self::$_instance;
    }
    
    /**
     * 获得dbObj
     * 
     * @param string $db 
     * 
     * @return mix
     */
    public function get() {
    	if (!$this->_db) {
    		$config = include APP_PATH . 'config/db.cfg.php';
    		$this->dbconn($config['host'], $config['username'], $config['password'], $config['database'], $config['type']);		
    	}
    	return $this->_db;    	
    }
    
    /**
     * 链接数据库实例
     * 
     * @param $dbHost 
     * @param $dbUsername
     * @param $dbPassword
     * @param $dbDatabase
     * @param $dbType
     * 
     * @return void
     */
	public function dbconn($dbHost, $dbUsername, $dbPassword, $dbDatabase, $dbType = 'mysql'){
		include ADODB_PATH . 'adodb.inc.php';
		$this->_db = NewADOConnection($dbType);
		$this->_db->Connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);
		$this->_db->SetFetchMode(ADODB_FETCH_ASSOC);
		$this->_db->execute("set names utf8");
	}	
}