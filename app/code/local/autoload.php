<?php

class Varian_Object {
    protected $_data = [];

    public function __construct($data) {
        $this->_data[] = $data;
    }
}

spl_autoload_register(function ($className) {
	$classPath = str_replace("_", "/", $className);
    // echo $classPath;
    @include $classPath . '.php';
});

spl_autoload_register(function ($className) {
	$classPath = str_replace("_", "/", $className);
    // echo $classPath;
    @include getcwd() . "/Lib/" . $classPath . '.php';
});

include getcwd()."/lib/PayPal/Autoload.php";

?>