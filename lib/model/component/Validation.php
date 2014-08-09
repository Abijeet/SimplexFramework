<?php
class Validation {
	private $valueBasedRules = array('minLength', 'maxLength', 'equalTo');
	private $errorProps = array();
	private $hasErrors = false;
	private $isSet = true;
	private $requireSet = array('notEmpty');
	
	function validateProps($data, $class, $validate) {
		foreach($validate as $prop => $rules) {
			$value = NULL;	
			if(isset($data[$class][$prop])) {
				$this->isSet = true;			
				$value = $data[$class][$prop];
			} else {
				$this->isSet = false;
			}
			
			foreach($rules as $rule => $params) {				
				$isValid = $this->validate($value, $rule, $params);
				if(!$isValid) {
					$this->setErrors($prop, $rule, $params);
					break;
				}
			}			
		}
		return $this->hasErrors;
	}
	
	private function validate($value, $rule, $params) {
		if(!$this->isSet) {
			if(in_array($rule, $this->requireSet)) {
				return false;	
			} else {
				return true;
			}			
		} 
		if(in_array($rule, $this->valueBasedRules)) {
			$expectedValue = $params['value'];
			return call_user_func(array($this, $rule), $value, $expectedValue);
		} else {
			return call_user_func(array($this, $rule), $value);
		}
	}
	
	private function notEmpty($value) {
		if(is_bool($value)) {
			// True/False should not be considered is_bool
			return true;
		}
		if(is_int($value)) {
			return true;
		}
		if(empty($value)) {
			return false;
		}
		return true;
	}
	
	private function minLength($value, $expectedLength) {
		if(strlen($value) < $expectedLength) {
			return false;
		}
		return true;
	}
	
	private function maxLength($value, $expectedLength) {
		if(strlen($value) > $expectedLength) {
			return false;
		}
		return true;
	}

	private function setErrors($prop, $rule, $params) {
		$this->hasErrors = true;
		if(empty($params['message'])) {
			$this->errorProps[$prop] = $rule;
		} else {
			$this->errorProps[$prop] = $params['message'];	
		}
	}

	function getErrors() {
		return $this->errorProps;
	}
}