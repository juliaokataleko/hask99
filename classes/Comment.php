<?php
class Comment {
	
	private $_data, $_rowCount;
	public $_db;
	
	public function __construct($post = null) {
		$this->_db = DB::getInstance();
	}
	
	public function postComment($fields = array()) {
		if(!$this->_db->insert('tbl_comments', $fields)) {
			throw new Exception('Algo correu mal ao publicar a sua ideia. tente de novo!');
		}
	}
	
	public function commentsList($table, $where) {
		if(!$this->_db->get($table, $where)) {
			throw new Exception('Algo correu mal ao listar as ideias. tente de novo!');
		}else {
			$this->_rowCount = $this->_db->count();
			return $this->_db->results();
		}
	}
	
	public function findComment($comment_id) {
		if($comment_id) {
			$field = 'post_id';
			$data = $this->_db->get('tbl_comments', array($field, '=', $comment_id));
			
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function findCommentDel($comment_id) {
		if($comment_id) {
			$field = 'comment_id';
			$data = $this->_db->get('tbl_comments', array($field, '=', $comment_id));
			
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