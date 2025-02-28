<?php

class Core_Model_Request {
    protected $_moduleName = "";
    protected $_controllerName = "";
    protected $_actionName = "";
    protected $_baseUrl = 'http://localhost/mvcproject/';
    protected $_baseDir = 'C:\xampp\htdocs\Mvcproject';

    public function __construct() {
        $uri = $this->getRequestUri();
        $uri = array_filter(explode("/", $uri));
        // echo "<pre>";
        // print_r($uri);
        // echo "</pre>";
        $this->_moduleName = isset($uri[0]) ? $uri[0] : "cms";
        $this->_controllerName = isset($uri[1]) ? $uri[1] : "index";
        $this->_actionName = isset($uri[2]) ? $uri[2] : "index";

        // return $this;
        // echo "<pre>";
        // print_r($this);
        // echo "</pre>";
    }

    public function getRequestUri() {
        $baseurl = $_SERVER['REQUEST_URI'];
        $baseurl = str_replace("/mvcproject/", "", $baseurl);
        return $baseurl;
    }

    public function getModuleName() {
        return $this->_moduleName;
    }

    public function getControllerName() {
        return $this->_controllerName;
    }
    
    public function getActionName() {
        return $this->_actionName;
    }

    public function getParam($field) {
        if(isset($_POST[$field])) {
            return $_POST[$field];
        } else {
            return "";
        }
    }

    public function getParams() {
        return $_POST;
    }
    
    public function getQuery($field) {
        if(isset($_GET[$field])) {
            return $_GET[$field];
        } else {
            return "";
        }
    }

}

?>