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
    require $classPath . '.php';
});

?>