<?php

require('Helper/BaseHelper.php');

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
    private $loadedHelpers;
    public $Html;

    const VIEW_FOLDER = 'view';
    const LAYOUT_FOLDER = 'Layout';
    const ELEMENT_FOLDER = 'Element';
    const HELPER_SUFFIX = 'Helper';

    function __construct($route) {
        $this->layout = 'default';
        $this->action = $route->action;
        $this->controller = $route->controllerName;
        $this->view = $route->view;
        $this->loadedHelpers = array();
    }

    function initialize($route, $controller) {
        $this->objController = $controller;
        $this->controller = $route->controllerName;
        $this->view = $route->view;
        $this->action = $route->action;
        $this->errors = $this->objController->getErrors();
        $this->values = $this->objController->getValues();
        $this->Html = new BaseHelper($this->errors, $this->values);
        $this->loadHelpers();
    }

    /**
     * This function loads the files from the Elements folder in the view folder.
     * @param string $element Name of the view file	
     * @return boolean false if file doesn't exist, else true
     */
    public function fetchElement($element) {
        extract($this->objController->getVars());
        $elementPath = $this->getElementPath($element);
        if (!file_exists($elementPath)) {
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
        $layoutPath = $this->getLayoutPath($this->layout);
        // Pull in the variables set by the controller.
        extract($this->objController->getVars());        
        if (!file_exists($layoutPath)) {
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
        extract($this->objController->getVars());
        if (!file_exists($viewPath)) {
            trigger_error('The view file at - ' . $viewPath . ' was not found!', E_USER_ERROR);
            return false;
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
    public function getTitle() {
        if (empty($this->title)) {
            $this->title = $this->getDefaultTitle();
        }
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    private function getDefaultTitle() {
        $action = strtolower($this->action);
        if ($action === 'index') {
            $action = '';
            return $this->controller;
        } else {
            $action = ucfirst($action);
            return $this->controller . ' - ' . $action;
        }
    }

    /**
     * Utility function used to get the view path
     * @param string $view Name of the view file
     * @param string $controller Name of the controller	
     * @return string Path of the view file
     */
    private function getViewPath($view = NULL) {
        $viewVar = $view;
        if (empty($view)) {
            $viewVar = $this->view;
        }
        // Remove the Controller from the end of the Controller name
        $controllerFolder = preg_replace('/Controller$/', '', $viewVar['controller']);
        return APP_PATH . View::VIEW_FOLDER . DS . $controllerFolder . DS . $viewVar['action'] . '.php';
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    /**
     * Utility function used to get the layout path
     * @param string $layout Name of the layout file
     * @return string Path of the layout file
     */
    private function getLayoutPath($layout) {
        return APP_PATH . View::VIEW_FOLDER . DS . View::LAYOUT_FOLDER . DS . $layout . '.php';
        ;
    }

    /**
     * Utility function used to get the element path
     * @param string $element Name of the element file
     * @return string Path of the element file
     */
    private function getElementPath($element) {
        return APP_PATH . View::VIEW_FOLDER . DS . View::ELEMENT_FOLDER . DS . $element . '.php';
        ;
    }

    private function getErrors() {
        return $this->errors;
    }

    public function addHelpers() {
        $helpers = func_get_args();
        $this->loadedHelpers = array_merge($this->loadedHelpers, $helpers);       
    }

    private function getHelperPath($helper) {
        return APP_PATH . View::VIEW_FOLDER . DS . 'Helper' . DS . $helper . View::HELPER_SUFFIX . '.php';
    }

    private function loadHelpers() {
        $allHelpers = func_get_args();
        if (empty($allHelpers)) {
            $allHelpers = $this->loadedHelpers;
        }
        foreach ($allHelpers as $helper) {
            $helperPath = $this->getHelperPath($helper);
            if (file_exists($helperPath) && is_file($helperPath)) {
                include_once($helperPath);
            }
            $helperObj = $helper . View::HELPER_SUFFIX;
            $this->{$helper} = new $helperObj($this->errors, $this->values);
        }
    }

}
