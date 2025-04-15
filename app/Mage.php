<?php

class Mage {
    private static $registry = [];
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

    public static function getSingleTon($class) {
        // echo $className;
        $class = str_replace("/", "_Model_", $class);
        $class = ucwords($class, "_");
        // echo $class . "<br>";

        if(isset(self::$registry[$class])) {
            return self::$registry[$class];
        } else {
            return self::$registry[$class] = new $class();
        } 
    }

    public static function getBlockSingleTon($class) {
        // echo $className;
        $class = str_replace("/", "_Block_", $class);
        $class = ucwords($class, "_");
        // echo $class . "<br>";

        if(isset(self::$registry[$class])) {
            return self::$registry[$class];
        } else {
            return self::$registry[$class] = new $class();
        } 
    }


    public static function getBlock($class) {
        // echo $className;
        $class = str_replace("/", "_Block_", $class);
        $class = ucwords($class, "_");
        // echo $class . "<br>";
        return new $class;
    }
    
    public static function getBaseDir() {
        return 'C:/xampp/htdocs/Mvcproject/';
    }
    
    public static function getBaseUrl() {
        return 'http://localhost/mvcproject/';
    }

    public static function log($data) {
        echo "<pre>";
        print_r($data);   
        echo "</pre>";
    }
}

?>