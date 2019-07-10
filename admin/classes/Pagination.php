<?php
class Pagination {
	
	private $_db;
	var $data;
	
	public function __construct($page = null) {
		//$this->_db = DB::getInstance();
	}
	
	public function paginate($values, $per_page) {
		
		$total_values = count ($values);
		
		if(isset($_GET['page'])) {
			$current_page = (int)$_GET['page'];
		} else {
			$current_page = 1;
		}
		
		$counts = ceil($total_values / $per_page);
		
		$param1 = ($current_page - 1) * $per_page;
		
		$this->data = array_slice($values, $param1, $per_page);
		
		for($x=1; $x<=$counts; $x++) {
			
			$numbers[] = $x;
			
		}
		
		return $numbers;
		
	}
	
	public function fetchResult() {
		$resultsValues = $this->data;
		return $resultsValues;
	}
	
}
