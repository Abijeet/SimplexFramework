<?php

class Router {

    public $controllerName;
    public $action;
    public $view;
    public $params;
    public $objController;
    public $objView;
    private $controller;
    private $error;

    /**
     * This constructor use the URL to determine -
     * 1. The controller that was requested
     * 2. The action in the controller that was requested
     * 3. The parameters passed via the URL
     * @return void
     */
    public function __construct() {
        $request = str_replace(strtolower(WEB_FOLDER), '', strtolower($_SERVER['REQUEST_URI']));
        $request = trim($request, '/');
        $requestParams = explode('/', $request);
        $size = count($requestParams);
        $this->controllerName = 'Home';
        $this->controller = 'HomeController';
        $this->action = 'index';

        // Check if the controller and action have been specified.
        if (!empty($requestParams[0])) {
            $this->setController($requestParams[0]);
        }
        if (!empty($requestParams[1])) {
            $this->setAction($requestParams[1]);
        }
        $this->view = array('controller' => $this->controllerName, 'action' => $this->action);
        $this->params = array();

        // i is 2 to skip the starting controller and action.
        for ($i = 2; $i < $size; ++$i) {
            $currVal = $requestParams[$i];
            if ($j = strpos($currVal, ':')) {
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
    public function route($controller = NULL, $action = NULL) {
        if (isset($controller) && isset($action)) {
            $this->setController($controller);
            $this->setAction($action);
        }
        if (!$this->isRequestValid()) {
            trigger_error($this->error, E_USER_ERROR);
            exit;
        }
        // Check for Authorization
        $hasAuthorization = $this->objController->Auth->isAuthorized($this->controllerName, $this->action);

        if ($hasAuthorization) {            
            $this->objController->beforeFilter();
            // Call the controller...
            call_user_func_array(array($this->objController, $this->action), array($this, $this->objView));
            
            // Reinitialize the view with data from controller.
            $this->objView->initialize($this, $this->objController);
            
            // Render the view
            $this->objView->render();
        } else {
            trigger_error('No authorizations.', E_USER_ERROR);
        }
    }

    public static function getURL($url = "") {
        if (empty($url)) {
            return "http://$_SERVER[HTTP_HOST]" . INDEX_URL;
        }
        return "http://$_SERVER[HTTP_HOST]" . INDEX_URL . $url . '/';
    }

    /**
     * This function determines if the controller and action exist.
     * If the controller exists, it creates a controller object 
     * which is then used to check if the action exists
     * @return true if the request is valid, else returns false.
     */
    private function isRequestValid() {
        if (!class_exists($this->controller)) {
            // Redirect to 404 page.
            $this->error = 'The controller specified - ' . $this->controller . ' does not exist.';
            return false;
        }
        $this->objView = new View($this);
        $this->objController = new $this->controller($this, $this->objView);
        $action = $this->action;
        if (!method_exists($this->objController, $action)) {
            // Redirect to 405. Method does not exist.
            $this->error = 'The action specified - ' . $action . ' does not exist.';
            return false;
        }
        return true;
    }

    private function setController($controller) {
        $this->controllerName = ucfirst(strtolower($controller));
        $this->controller = $this->controllerName . 'Controller';
    }

    private function setAction($action) {
        $this->action = strtolower($action);
    }

}

?>