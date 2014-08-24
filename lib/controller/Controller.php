<?php

require(__DIR__ . '/component/Authorization.php');
require(__DIR__ . '/component/Session.php');

/**
 * The controller base class.
 */
class Controller {

    protected $route;
    protected $request;
    public $Auth;
    public $Session;
    private $vars;
    private $objView;

    function __construct($route, $view) {
        $this->route = $route;
        if (Model::Load($route->controllerName)) {
            $this->{$route->controllerName} = new $route->controllerName();
        }
        $this->var = array();
        $this->objView = $view;
        $this->Session = Session::getSessionObj();
        $this->Auth = Authorization::getAuthObj($this->Session->getUserType());
        $this->request = new Request();
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
        if (file_exists($controllerPath)) {
            include($controllerPath);
            return true;
        }
        return false;
    }

    /**
     * This function can be used to set the view that is to be rendered.
     * @param string $viewPath Name of the view	
     * @return void
     */
    final function render($viewPath) {
        if (is_string($viewPath)) {
            $this->route->view['action'] = $viewPath;
        }
        if (is_array($viewPath)) {
            if (!empty($viewPath['controller'])) {
                $this->route->view['controller'] = $viewPath['controller'];
            }
            if (!empty($viewPath['action'])) {
                $this->route->view['action'] = $viewPath['action'];
            }
        }
    }

    final function redirect($controller, $action = NULL, $params = NULL) {
        if (empty($action)) {
            $action = 'index';
        }
        if (empty($params) || !is_array($params)) {
            $params = array();
        }
        $requestParams = '';
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $requestParams .= "$key:$value/";
            } else {
                $requestParams .= "$value/";
            }
        }
        $baseUrl = Router::getURL("$controller/$action");
        header('Location: ' . $baseUrl . $requestParams);
        die();
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
        $this->objView->setTitle($title);
    }

    final function getTitle() {
        return $this->objView->getTitle();
    }

    final function setLayout($layout) {
        $this->objView->setLayout($layout);
    }

    final function getLayout() {
        return $this->objView->getLayout();
    }

    final function getVars() {
        return $this->vars;
    }

    final function getErrors() {
        if (empty($this->{$this->route->controllerName})) {
            return false;
        }
        return $this->{$this->route->controllerName}->getErrors();
    }
    
    final function getValues() {
        return $this->request->data;
    }
    
    final function addHelpers($helpers) {
        $this->objView->addHelpers($helpers);
    }
}