<?php

class Mage {
    public static function init() {
        $front = new Core_Controller_Front();
        // $action = new Core_Controller_Front_Action();
        $front->init();
    }

    public static function getModel($class) {
        // echo $className;
        $class = str_replace("/", "_Model_", $class);
        $class = ucwords($class, "_");
        // echo $class . "<br>";
        return new $class;
    }

    public static function getBlock($class) {
        // echo $className;
        $class = str_replace("/", "_Block_", $class);
        $class = ucwords($class, "_");
        // echo $class . "<br>";
        return new $class;
    }
    
    public static function getBaseDir() {
        return 'C:/xampp/htdocs/Mvc/';
    }
    
    public static function getBaseUrl() {
        return 'http://localhost/mvc/';
    }
}

?>