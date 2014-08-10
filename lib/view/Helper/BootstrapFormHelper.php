<?php
class BootstrapFormHelper {
	//$this->Form->input('User.username', array('type' => 'text', 'id' => "txtUsername", 'label' => 'Username'));
	private $ctrlPrefix = array('select' => 'ddl', 'text' => 'txt', 'password' => 'txt', 'checkbox' => 'chk', 'radio' => 'rdo');
	private $errors;
	
	private function __construct($errors) {
		$this->errors = $errors;
	}
	
	function input($name, $options) {
		$type = 'text';
		if(isset($options['type'])) {
			$type = $options['type'];
		}
		$name = str_split($name);
		$model = '';
		$ctrlName = $name[0];		
		if(count($name) === 2) {
			$model = $name[0] . '.';
			$ctrlName = $name[1];
		}
		
		if(isset($options['id'])) {
			$id = $options['id'];
		} else {
			$id = $this->ctrlPrefix[$type] . ucfirst($ctrlName) ;
		}		
		$hasError = $this->hasErrors($ctrlName);
		$divStart = $this->getInputStart();
		$label = $this->getLabel($id, $ctrlName);
		$ctrlHtml = $this->getCtrlHtml();
		$divEnd = $this->getInputEnd();
		return $divStart . $label . $ctrlHtml . $divEnd;
	}
	/*
	<div class="form-group has-error has-feedback">
		<label for="txtUsername" class="control-label">Confirm Password</label> -- DONE
		<input type="text" id="txtConfirmPassword" class="form-control">
		<span class="glyphicon glyphicon-remove form-control-feedback"></span>
	</div>
	*/
	private function getLabel($id, $ctrlName) {
		return '<label for="' . $id . '">' . ucfirst($ctrlName) . '</label>';
	}
	
	private function getInputStart($hasError = false) {
		$classes = 'form-group';
		if($hasError) {
			$classes .= ' has-error';
		}
		return '<div class="' . $classes . '">';
	}
	
	private function getCtrlHtml($type, $id, $value = "") {
		if($type !== 'select') {
			return '<input type="' . $type . '" class="form-control" id="' . $id . '" value="' . $value .'>';	
		}		
	}
	
	private function getInputEnd() {
		return '</div>';
	}
		
	private function hasErrors($ctrlName) {
		if(empty($this->errors[$ctrlName])) {
			return false;
		}
		return $this->errors[$ctrlName];
	}
}