<?php
class Read {
	
	private $_data, $_rowCount;
	public $_db;
	
	public function __construct($post = null) {
		$this->_db = DB::getInstance();
	}
	
	public function countRead($fields = array()) {
		if(!$this->_db->insert('table_reads', $fields)) {
			throw new Exception('Algo correu mal.');
		}
	}
	
	
	
	public function findReads($post_id) {
		if($post_id) {
			$field = 'post_id';
			$data = $this->_db->get('table_reads', array($field, '=', $post_id));
			
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	
	
	public function data() {
		return $this->_data;
	}
	
	public function queryRowCount() {
		return $this->_rowCount;
	}
	
}