<?php

class Core_Controller_Front {
    public function init() {
        // echo "234<br>";

        $request = Mage::getModel("core/request");
      
        $actionName = $request->getActionName()."Action";
        $class = sprintf("%s_Controller_%s",$request->getModuleName(), $request->getControllerName());
        $class = ucwords($class, "_");

        // echo $class;
        // echo $actionName;
        $obj = new $class();
        $obj->$actionName();    
    }
}

?>