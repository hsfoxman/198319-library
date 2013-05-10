<?php
/**
 * 分页
 */
class Database_Page_Core {

		public $rows = 0;
		public $pages = 0;
		public $pagecurrent = 0;
		public $limit;
		public $result;

		public function __construct($limit = 999999, $pagecurrent = 1){
			$this->limit = $limit;
			$this->pagecurrent = is_numeric($pagecurrent) ? $pagecurrent : 1;
		}

		public function execute($adodb, $sql){
			$recordSet = $adodb->PageExecute($sql, $this->limit, $this->pagecurrent);
			$rs = array ();
			if (isset ($recordSet->fields)) {
				while (!$recordSet->EOF) {
					$rs[] = $recordSet->fields;
					$recordSet->MoveNext();
				}
				$this->rows = $recordSet->MaxRecordCount();
				$this->pages = $recordSet->LastPageNo() < 0 ? 0 : $recordSet->LastPageNo();
				$this->current = $recordSet->AbsolutePage() < 1 ? 1 : $recordSet->AbsolutePage();
			}
			return $this->result = $rs;
		}
	}
