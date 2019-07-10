<?php
class Post {
	
	private $_data;
	public $_db;
	
	public function __construct($post = null) {
		$this->_db = DB::getInstance();
	}
	
	public function postIdea($fields = array()) {
		if(!$this->_db->insert('table_posts', $fields)) {
			throw new Exception('Algo correu mal ao publicar a sua ideia. tente de novo!');
		}
	}
	
	public function postsList($table, $where) {
		if(!$this->_db->get($table, $where)) {
			throw new Exception('Algo correu mal ao listar as ideias. tente de novo!');
		}else {
			return $this->_db->results();
		}
	}
	
	public function findPost($post_id) {
		if($post_id) {
			$field = 'post_id';
			$data = $this->_db->get('table_posts', array($field, '=', $post_id));
			
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
	
}