<?php
/**
* The controller base class.
*/
class Controller {
	protected $route;
	public $vars;
	private $title;
	private $layout;
	private $view;
	
	function __construct($route) {
		$this->route = $route;
		$this->var = array();
		$this->title = '';
		$this->layout = 'default';
	}
	
	/**
	* This function is used to set values, that can then be used by the view.
	* @param string Name of the value 
	* @param string The actual value	
	* @return void
	*/
	final function set($key, $value) {
		$this->vars[$key] = $value;
	}
	
	/**
	* This function returns the value for a particular key
	* @param string $key Name of the key	
	* @return mixed
	*/
	final function get($key) {
		return $this->vars[$key];
	}
	
	/**
	* This function is used to load a controller
	* @param string $controller Name of the controller	
	* @return boolean - True if controller was loaded, else false.
	*/
	final static function Load($controller) {
		$controllerPath = APP_PATH . CONTROLLER_FOLDER . DS . $controller . '.php';
		if(file_exists($controllerPath)) {
			include($controllerPath);
			return true;
		}
		return false;
	}
	
	/**
	* This function can be used to set the view that is to be rendered.
	* @param string $view Name of the view	
	* @return void
	*/
	final function render($view) {
		$this->route->view =  $view;
	}
	
	/**
	* This function lists the parameters that have been passed to the controller
	* via the URL
	* @return Array of parameters.
	*/
	final function getParameters() {
		return $this->route->params;
	}
	
	final function setTitle($title) {
		$this->title = $title;
	}
	
	final function getTitle() {
		return $this->title;
	}

	final function setLayout($layout) {
		$this->layout = $layout;
	}
	
	final function getLayout() {
		return $this->layout;
	}

}
?>