<?php
class Validate {
	private $_passed = false,
			$_errors = array(),
			$_db = null;
			
	public function Validate() {
		$this->_db = DB::getInstance();
	}
	
	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {
				
				$value = $source[$item];
				$item = escape($item);
				
				if($rule === 'required' && empty($value)){
					$this->addError("{$item} é necessária");
				}else if(!empty($value)) {
					switch($rule) {
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$item} deve ter no mínimo {$rule_value} carateres.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$item} deve ter no máximo {$rule_value} carateres.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]) {
								//$this->addError("{$rule_value} deve ser igual à {$item}.");
								$this->addError("As palavras-passe devem ser iguais.");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()) {
								$this->addError("{$item} já existe");
							}
						break;
					}
				}
			}
		}
		
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		
		return $this;
	}
	
	public function addError($error) {
		$this->_errors[] = $error;
	}
	
	public function errors() {
		return $this->_errors;
	}
	
	public function passed() {
		return $this->_passed;
	}

}