<?php

class Core_Controller_Front_Action {
    public function getRequest() {
        return Mage::getSingleTon("core/request");  
    }

    public function getSession() {
        return Mage::getSingleTon("core/session");
    }
    public function getMessage() {
        return Mage::getSingleTon("core/message");
    }

    public function redirect($url) {
        header('location: '.Mage::getBaseUrl().$url);
        return $this;
    }

    public function getLayout() {
        return Mage::getBlockSingleTon("core/layout");
    }
}

?>