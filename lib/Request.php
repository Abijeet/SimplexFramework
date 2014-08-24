<?php

class Request {

    public $data;
    private $isAjax = false;
    private $isPost = false;
    private $isGet = false;

    function __construct() {
        $this->buildRequestObj();
        $this->detectRequestType();
    }

    private function buildRequestObj() {
        if (isset($_REQUEST['data'])) {
            $this->data = $_REQUEST['data'];
        }
    }

    private function detectRequestType() {
        $requestType = $_SERVER['REQUEST_METHOD'];
        if ($requestType === 'POST') {
            $this->isPost = true;
        } else if ($requestType === 'GET') {
            $this->isGet = true;
        }
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->isAjax = true;
        }
    }

    public function isAjax() {
        return $this->isAjax;
    }

    public function isGet() {
        return $this->isGet;
    }

    public function isPost() {
        return $this->isPost;
    }

}
