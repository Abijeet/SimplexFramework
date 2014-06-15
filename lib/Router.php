<?php
class Router {	

	public $controller;
	public $action;
	public $view;
	public $params;	
	public $layout;
	public $pageTitle;
	public $objController;
	public $objView;
	
	private $error;
	
	/**
	* This constructor use the URL to determine -
	* 1. The controller that was requested
	* 2. The action in the controller that was requested
	* 3. The parameters passed via the URL
	* 4. It also initializes the layout and view
	* @return boid
	*/
	public function __construct() {
		$request = str_replace(strtolower(ROOT_FOLDER), '', strtolower($_SERVER['REQUEST_URI']));
		$request = trim($request, '/');
		$requestParams = explode('/', $request);
		$size = count($requestParams);
		$this->controller = 'HomeController';
		$this->action = 'index';
		$this->layout = 'default';
		
		// Check if the controller and action have been specified.
		if(!empty($requestParams[0])) {
			$this->controller = ucfirst(strtolower($requestParams[0])) . 'Controller';
		}
		if(!empty($requestParams[1])) {
			$this->action = strtolower($requestParams[1]);			
		}
		$this->view = $this->action;
		$this->params = array();
				
		// i is 2 to skip the starting controller and action.
		for($i = 2; $i < $size; ++$i) {
			$currVal = $requestParams[$i];
			if($j = strpos($currVal, ':')) {				
				$key = substr($currVal, 0, $j);
				$value = substr($currVal, $j + 1);
				$this->params[$key] = $value;
			} else {
				$this->params[] = $requestParams[$i];
			}
		}
	}
	
	/**
	* This function which routes the request between the controller and the view		
	* @return void
	*/
	public function route() {
		if(!$this->isRequestValid()) {
			trigger_error($this->error, E_USER_ERROR);
			return;
		}				
		call_user_func_array(array($this->objController, $this->action), array($this));
		$this->objView = new View($this, $this->objController);
		$this->objView->render();
	}
	
	/**
	* Determines if the controller and action exist.
	* If the controller exists, it creates a controller object 
	* which is then used to check if the action exists
	* @return true if the request is valid, else returns false.
	*/
	private function isRequestValid() {
		if(!class_exists($this->controller)) {
			// Redirect to 404 page.
			$this->error = 'The controller specified - ' . $this->controller . ' does not exist.';
			return false;
		} 
		$this->objController = new $this->controller($this);
		$action = $this->action;
		if(!method_exists($this->objController, $action)) {
			// Redirect to 405. Method does not exist.
			$this->error = 'The action specified - ' . $action . ' does not exist.';
			return false;
		}
		return true;
	}
}
?>