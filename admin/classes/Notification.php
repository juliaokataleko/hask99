<?php
class Notification {
	
	private $_data;
	public $_db;
	
	public function __construct($post = null) {
		$this->_db = DB::getInstance();
	}
	
	public function insertNotification($fields = array()) {
		if(!$this->_db->insert('tbl_alerts', $fields)) {
			throw new Exception('Algo correu mal...!');
		}
	}
	
	public function updateNotification($alert_id, $fields = array()) {
		$id = $alert_id;
		if(!$this->_db->update('tbl_alerts', 'alertId', $id, $fields)) {
			throw new Exception('Algo correu mal...!');
		}
	}
	
	public function notificationList($table, $where) {
		if(!$this->_db->get($table, $where)) {
			throw new Exception('Algo correu mal ao listar as notificações...!');
		}else {
			return $this->_db->results();
		}
	}
	
	public function findNotification($user_id) {
		if($user_id) {
			$field = 'user_id_receive';
			$data = $this->_db->get('tbl_alerts', array($field, '=', $user_id));
			
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