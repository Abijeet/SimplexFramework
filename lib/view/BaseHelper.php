<?php
class BaseHelper {
	protected $ctrlPrefix = array('select' => 'ddl', 'text' => 'txt', 'password' => 'txt', 'checkbox' => 'chk', 'radio' => 'rdo');
	protected $errors;
	protected $values;
	
	protected function __construct($errors, $values) {
		$this->errors = $errors;
		$this->values = $values;
	}
	
	protected function input($name, $options) {
		$inputInfo = array(
			'class' => '',
			'id' => '',
			'name' => $name,
			'type' => 'text',
			'options' => '',
			'value' => '',
			'label' => '',
			'error_msg' => false
		);
		$ctrlName = '';
		$model = '';
		$inputInfo['name'] = $this->getInputName($name, $ctrlName, $model);
		$inputInfo['id'] = $this->getInputId($ctrlName, $options);
		$inputInfo['type'] = $this->getType($options);
		$inputInfo['label'] = $this->getLabel($options);
		$inputInfo['value'] = $this->getValue($ctrlName, $model);
	}
	
	protected function getInputName($name, &$ctrlName, &$model) {
		$name = explode (".", $name);
		$model = '';
		$ctrlName = $name[0];		
		if(count($name) === 2) {
			$model = $name[0];
			$ctrlName = $name[1];
			return "data[$model][$ctrlName]";
		}
		return $ctrlName;
	}
	
	protected function getInputId($options, $ctrlName) {
		if(isset($options['id'])) {
			return $options['id'];
		} else {
			return$this->ctrlPrefix[$type] . ucfirst($ctrlName) ;
		}
	}
	
	protected function getType($options) {
		if(!empty($options['type'])) {
			return $options['type'];
		}
		return 'text';
	}
	
	protected function getLabel($options, $ctrlName) {
		if(isset($options['label'])) {
			return $options['label'];
		}
		return ucfirst($ctrlName);
	}
	
	protected function getValue($ctrlName, $model) {
		if(empty($model)) {
			return $this->values[$ctrlName];
		} else {
			return $this->values[$model][$ctrlName];
		}
		
	}

	protected function getError($ctrlName) {
		if(isset($this->error[$ctrlName])) {
			return $this->error[$ctrlName];
		}
		return false;
	}
}
