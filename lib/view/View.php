<?php
/**
* The base class for views.
*/
class View {
	private $controller;
	private $layout = 'default';
	private $objController;
	private $view;
	private $action;
	private $title;	
	private $errors;
	
	const VIEW_FOLDER = 'view';
	const LAYOUT_FOLDER = 'Layout';
	const ELEMENT_FOLDER = 'Element';
	
	function __construct($route, $controller) {
		$this->objController = $controller;		
		$this->layout = $controller->getLayout();
		$this->title = $controller->getTitle();

		$this->controller = $route->controllerName;
		$this->view = $route->view;
		$this->action = $route->action;
		$this->errors =  $this->objController->getErrors();
	}
	
	/**
	* This function loads the files from the Elements folder in the view folder.
	* @param string $element Name of the view file	
	* @return boolean false if file doesn't exist, else true
	*/
	public function fetchElement($element) {
		$elementPath = $this->getElementPath($element);
		if(!file_exists($elementPath)) {
			return false;
		}
		include($elementPath);
		return true;
	}
	
	/**
	* This function renders the layout file from the Layouts folder
	* The layout to be rendered depends on the layout property
	* @return boolean false if file doesn't exist, else true
	*/
	public function render() {			
		$layoutPath  = $this->getLayoutPath($this->layout);
		if(!file_exists($layoutPath)) {
			return false;
		}
		include($layoutPath);
		return true;
	}
	
	/**
	* This function loads the view file depending on the view property.
	* This function is called from inside the layout file.
	* @return boolean false if file doesn't exist, else true
	*/
	private function fetchContent() {		
		$viewPath = $this->getViewPath($this->view);
		if(!file_exists($viewPath)) {
			trigger_error('The view file at - ' . $viewPath . ' was not found!', E_USER_ERROR);
			return false;
		}
		// Pull in the variables set by the controller.
		$controllerVars = $this->objController->getVars();
		if(isset($controllerVars)) {
			foreach($controllerVars as $key => $value) {
				$$key = $value;
			}	
		}		
		include($viewPath);
		return true;
	}
	
	/**
	* This function determines the title. 
	* If the title was set, it'll return that title otherwise the
	* title will be set as the Controller - Action
	* Called from inside the layout file
	* @return string Title for the page
	*/
	private function getTitle() {
		if(empty($this->title)) {
			$action = strtolower($this->action);
			if($action === 'index') {
				$action = '';
				return $this->controller;
			} else {
				$action = ucfirst($action);
				return $this->controller . ' - ' . $action;
			}			
		}
		return $this->title;
	}
	
	/**
	* Utility function used to get the view path
	* @param string $view Name of the view file
	* @param string $controller Name of the controller	
	* @return string Path of the view file
	*/
	private function getViewPath($view = NULL) {
		$viewVar = $view;
		if(empty($view)) {
			$viewVar = $this->view;
		}			
		// Remove the Controller from the end of the Controller name
		$controllerFolder = preg_replace('/Controller$/', '', $viewVar['controller']);
		return APP_PATH . View::VIEW_FOLDER . DS . $controllerFolder . DS . $viewVar['action'] . '.php';
	}
	
	/**
	* Utility function used to get the layout path
	* @param string $layout Name of the layout file
	* @return string Path of the layout file
	*/
	private function getLayoutPath($layout) {
		return APP_PATH . View::VIEW_FOLDER . DS .  View::LAYOUT_FOLDER . DS . $layout . '.php';;
	}
	
	/**
	* Utility function used to get the element path
	* @param string $element Name of the element file
	* @return string Path of the element file
	*/
	private function getElementPath($element) {
		return APP_PATH . View::VIEW_FOLDER . DS . View::ELEMENT_FOLDER . DS . $element . '.php';;
	}

	private function getErrors() {
		return $this->errors;
	}
}
?>