<?php
class BootstrapForm extends BaseHelper{	
	private $ctrlPrefix = array('select' => 'ddl', 'text' => 'txt', 'password' => 'txt', 'checkbox' => 'chk', 'radio' => 'rdo');
	private $errors;
	
	public function __construct($errors) {
		$this->errors = $errors;
	}
	
	function input($name, $options) {
		$inputInfo = parent::input($name, $option);
		$type = 'text';
		if(isset($options['type'])) {
			$type = $options['type'];
		}
		$name = explode (".", $name);
		$model = '';		
		$ctrlName = $name[0];		
		if(count($name) === 2) {
			$model = $name[0];
			$ctrlName = $name[1];
		}
		$label = ucfirst($ctrlName);
		if(isset($options['label'])) {
			$label = $options['label'];
		}
		if(isset($options['id'])) {
			$id = $options['id'];
		} else {
			$id = $this->ctrlPrefix[$type] . ucfirst($ctrlName) ;
		}		
		$hasError = $this->hasErrors($ctrlName);
		$divStart = $this->getInputStart();
		$label = $this->getLabel($id, $label);
		$ctrlHtml = $this->getCtrlHtml($type, $id, $model, $ctrlName);
		$divEnd = $this->getInputEnd();
		return $divStart . $label . $ctrlHtml . $divEnd;
	}
	
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
	
	private function getCtrlHtml($type, $id, $model, $name, $value = "") {
		if($type === 'text' || $type === 'password') {
			return '<input id="' . $id . '" type="' . $type . '" name="data[' . $model . '][' . $name . ']" class="form-control" value="' . $value .'">';	
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