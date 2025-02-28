<?php

class Core_Controller_Front_Action {
    public function getRequest() {
        return Mage::getSingleTon("core/request");  
    }

    public function getSession() {
        return Mage::getSingleTon("core/session");
    }

    public function redirect($url) {
        header('location: '.Mage::getBaseUrl().$url);
        return $this;
    }
}

?>