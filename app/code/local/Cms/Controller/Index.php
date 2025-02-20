<?php

class Cms_Controller_Index extends Core_Controller_Front_Action {
    // public function __construct() {
    //     // $class = Mage::getBlock('core/layout');    
    //     // echo $class;
        
    // }

    public function indexAction() {
        // echo "default index page";
        $layout =  Mage::getBlock('core/layout');
        $layout->toHtml();
    }
}

?>