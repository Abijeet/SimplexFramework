<?php
class BootstrapForm {	
	private $ctrlPrefix = array('select' => 'ddl', 'text' => 'txt', 'password' => 'txt', 'checkbox' => 'chk', 'radio' => 'rdo');
	private $errors;
	private $values;
	
	public function __construct($errors, $values) {
		$this->errors = $errors;
		$this->values = $values;	
	}
	
}