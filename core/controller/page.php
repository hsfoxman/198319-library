<?php
/**
 * 
 * 站点页面控制器 抽象方法
 *
 */
abstract class Controller_Page_Core extends Controller_Init_Core {
	
	public function __construct() {
		parent::__construct();
	}
	
	abstract public function doGet();
	
	abstract public function doPost();
}