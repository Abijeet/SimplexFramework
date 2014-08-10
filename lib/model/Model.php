<?php
require(__DIR__ . '/component/Validation.php');
/**
* The Model base class
*/
class Model {
	private $validation;
	private $errors;
	function __construct() {
		$this->validation = new Validation();
	}
	
	/**
	* This function is used to load a controller
	* @param string $controller Name of the controller	
	* @return boolean - True if controller was loaded, else false.
	*/
	final static function Load($model) {
		$modelPath = APP_PATH . MODEL_FOLDER . DS . $model . '.php';
		if(file_exists($modelPath)) {
			include($modelPath);
			return true;
		}
		return false;
	}
	
	final public function save($data) {
		$isValid = $this->validation->validateProps($data, get_class($this), $this->validate);
		if(!$isValid) {			
			return ErrorType::VALIDATION_ERROR;			
		}
	}
	
	final public function getErrors() {
		$this->validation->getErrors();
	}
}
?>