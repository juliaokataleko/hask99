<?php
class Like {
	
	private $_data, $_rowCount;
	public $_db;
	
	public function __construct($post = null) {
		$this->_db = DB::getInstance();
	}
	
	public function postLike($fields = array()) {
		if(!$this->_db->insert('table_like', $fields)) {
			throw new Exception('Algo correu mal ao publicar a sua ideia. tente de novo!');
		}
	}
	
	public function likesList($table, $where) {
		if(!$this->_db->get($table, $where)) {
			throw new Exception('Algo correu mal ao listar as ideias. tente de novo!');
		}else {
			$this->_rowCount = $this->_db->count();
			return $this->_db->results();
		}
	}
	
	public function findLike($comment_id) {
		if($comment_id) {
			$field = 'post_id';
			$data = $this->_db->get('table_like', array($field, '=', $comment_id));
			
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function findLikeDel($comment_id) {
		if($comment_id) {
			$field = 'like_id';
			$data = $this->_db->get('table_like', array($field, '=', $comment_id));
			
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