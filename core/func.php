<?php
/**
 * 全局公用方法
 */

/**
 * 自动加载 
 */
include CORE_PATH . 'loader/loader.php';
spl_autoload_register(array('Loader_Loader_Core', 'loadClass'));

/**
 * 调试输出
 * 
 * @param  mixed  $var   The variable to dump.
 * @param  string $label OPTIONAL Label to prepend to output.
 * @param  bool   $echo  OPTIONAL Echo output if true.
 * 
 * @return string
 */
function debug($var, $label=null, $echo=true) {
	require_once 'Zend/Debug.php';
	Zend_Debug::dump($var);
}

/**
 * 页面控制器执行方法
 * 
 * @param string classname
 *
 * @return void
 */
function run($classname) {
	$class = new $classname;
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET':
			$class->doGet();
			break;
		case 'POST':
			$class->doPost();
			break;		
	}

	
}

/**
 * 简单验证码
 * 
 * @param int width
 * @param int height
 *
 * @return void
 */
function inumber($width=80, $height=20) {		
	$_SESSION["inumber"] = $num = (string)rand(1000, 9999);
	$img = imagecreate($width, $height);
	imagecolorallocate($img, 255, 255, 255);
	for($i=1; $i<=128; $i++) imagestring($img, 1, mt_rand(1, $width), mt_rand(1, $height), "*", imageColorAllocate($img, mt_rand(220, 255), mt_rand(220, 255), mt_rand(220, 255)));
	for($i=0; $i<strlen($num); $i++) imagestring($img, 4, $i*$width/4+6, mt_rand(1, $height/4),  $num[$i], imageColorAllocate($img, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200)));
	
	header("Content-type: image/png");
	imagejpeg($img);
	imagedestroy($img);
	
	exit;
}

/**
 * 跳转
 *
 * @param string $url
 * @param int $method
 * @param mix $extend
 *
 * @return void
 */
function location($url, $extend = 2, $method = 1) {
	switch ($method) {
		case 3:
			if (is_int($extend)) {
				header("HTTP/1.1 200 OK");
				echo '<meta http-equiv="refresh" content="' . $extend . '; url=' . $url . '" >';
			}
			break;
		case 2:
			if (is_string($extend)) {
				header("HTTP/1.1 200 OK");
				echo '<script language="javascript" >alert("' . $extend . '");window.location.replace(\'' . $url . '\');</script>';
			}
			break;
		case 1:	//302方式
		default:
			header('Location:' . $url);
			break;
	}
	exit;
}

