<?php
/**
 * 文件上传
 */
class File_File_Core {

	  public $upfileType;
	  public $upfileSize;
	  public $upfileName;
	  public $upfile;
	  public $dAlt;
	  public $extentionList;
	  public $tmp;
	  public $arri;
	  public $datetime;
	  public $date;
	  public $filestr;
	  public $size;
	  public $ext;
	  public $check;
	  public $flashDirectory;
	  public $extention;
	  public $filePath;
	  public $baseDirectory;
	  public $error = '';
	  public $isSuccess = false;
	 
	  public function __construct($file) {
	  		$this->setFileType($file['type']); 
			$this->setFileName($file['name']); 
			$this->setFileSize($file['size']); 
			$this->setUpfile($file['tmp_name']);  
			$this->setSize(1000);
		    $this->setExtention();
		    $this->setDate();              
		    $this->setDatetime(); 
			$this->setBaseDirectory(UPLOAD_PATH . 'case');
	  }

	  /**
	   * 设置文件类型
	   * 
	   * @param string $upfileType
	   * 
	   * @return void
	   */
	  public function setFileType($upfileType) {
			$this->upfileType = $upfileType;
	  }
	 
	 /**
	  * 设置文件名
	  * 
	  * @param string $upfileName
	  * 
	  * @return void
	  */
	  public function setFileName($upfileName) {
	  	   $this->upfileName = $upfileName;       
	  }
	 
	  /**
	   * 取得文件在服务端储存的临时文件名
	   * 
	   * @param string $upfile
	   * 
	   * @return void
	   */
	  public function setUpfile($upfile) {
	   	   $this->upfile = $upfile;           
	  }
	   
	 /**
	  * 设置文件尺寸
	  * 
	  * @param $upfileSize
	  * 
	  * @return void
	  */
	  public function setFileSize($upfileSize) {
	   	   $this->upfileSize = $upfileSize;       
	  }
	 
	  /**
	  * 取得文件扩展名
	  * 
	  * @return void
	  */
	  public function getExtention() {
	     $this->extention = preg_replace('/.*\.(.*[^\.].*)*/iU', '\\1', $this->upfileName);
	  }
	     
	  /**
	   * 按时间生成文件名
	   * 
	   * @return void
	   */
	  public function setDatetime() {
	     $this->datetime = date('YmdHis');
	  }
	 
	  /**
	   * 按日期生成目录名称
	   * 
	   * @return void
	   */
	  public function setDate() {
	   	 $this->date = date('Y-m-d');         
	  }
	 
	  /**
	   * 默认允许上传的扩展名称
	   * 
	   * @return void
	   */
	  public function setExtention() {
	  	 	$this->extentionList = 'doc|xls|ppt|avi|txt|gif|jpg|jpeg|bmp|png'; ;
	  } 
	 
	  /**
	   * 设置最大允许上传的文件大小
	   * 
	   * @param int $size
	   * 
	   * @return void
	   */
	  public function setSize($size) {
	  		$this->size = $size;             
	  }
	 
	  /**
	   * 生成文件存储根目录;
	   * 
	   * @param string $directory
	   * 
	   * @return void
	   */
	  public function setBaseDirectory($directory) {
	   		$this->baseDirectory = $directory; 
	  }
	 
	  /**
	   * 生成文件存储子目录
	   * 
	   * @return void
	   */
	  public function setFlashDirectory() {
	   $this->flashDirectory = $this->baseDirectory . '/' . $this->date; 
	  }
	 
	  /**
	   * 错误处理
	   * 
	   * @param string $errstr
	   * 
	   * @return void
	   */
	  function showerror($errstr = '未知错误！'){
	   		$this->error = $errstr;
	  }

	  /**
	   * 如果根目录没有创建则创建文件存储目录
	   * 
	   * @return void
	   */
	  public function mkBaseDir() {
	   		if (! file_exists($this->baseDirectory)) {   
	    		@mkdir($this->baseDirectory, 0777);
	   		}
	  }
	
	  /**
	   * 如果根目录没有创建则创建文件存储目录
	   * 
	   * @return void
	   */
	  public function mkDir(){
	   		if (! file_exists($this->flashDirectory)) { 
	    		@mkdir($this->flashDirectory, 0777);   
	   		}
	  } 
	 
	  /**
	   * 以数组的形式获得分解后的允许上传的文件类型
	   * 
	   * @return void
	   */
	  public function getCompareExtention() {
	   		$this->ext = explode('|', $this->extentionList);
	  }
	 
	  /**
	   * 检测扩展名是否违规
	   * 
	   * @return void
	   */
	  public function checkExtention() {
	   		for($i=0;each($this->ext);$i++) {
	   			 if($this->ext[$i] == strtolower($this->extention)) {
	     			$this->check = true;               
	     			break;
	    		}
	   		}
	   		if(!$this->check){
	   			$this->showerror('正确的扩展名必须为' . $this->extentionList . '其中的一种！');
	   		}
	   }
	 
	  /**
	   * 检测文件大小是否超标
	   * 
	   * @return void
	   */
	  public function checkSize() {
	   		if($this->upfileSize > round($this->size * 1024)) {
	    		$this->showerror('上传附件不得超过' . $this->size . 'KB'); //超过则警告;
	   		}
	  }
	
	  /**
	   * 文件完整访问路径
	   * 
	   * @return void
	   */
	  public function setFilePath() {
	   	$this->filePath = $this->flashDirectory . '/' . $this->datetime . '.' . $this->extention;
	  }
	 
	  /**
	   * 上传文件
	   * 
	   * @return void
	   */
	  public function copyFile() {
	   		if(copy($this->upfile,$this->filePath)){
	    		$this->isSuccess = true; 
	   		}else {
	    		$this->showerror('意外错误，请重试！'); 
	   		}
	  }
	 
	  /**
	   * 完成保存
	   * 
	   * @return void
	   */
	  public function save() {
	   $this->setFlashDirectory();  //初始化文件上传子目录名;
	   $this->getExtention();     //获得文件扩展名;
	   $this->getCompareExtention(); //以"|"来分解默认扩展名;
	   $this->checkExtention();    //检测文件扩展名是否违规;
	   $this->checkSize();      //检测文件大小是否超限;  
	   $this->mkBaseDir();      //如果根目录不存在则创建；
	   $this->mkDir();        //如果子目录不存在则创建;
	   $this->setFilePath();     //生成文件完整访问路径;
	   $this->copyFile();       //上传文件;
	   return $this->isSuccess;
	  }	
	  
	  /**
	   * 取得文件路径
	   * 
	   * @return string
	   */
	  public function getFilePath() {
	  		return $this->date . '/' . $this->datetime . '.' . $this->extention;
	  }
}