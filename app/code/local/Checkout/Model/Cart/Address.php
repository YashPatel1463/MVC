<?php

class Checkout_Model_Cart_Address extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Checkout_Model_Resource_Cart_Address";
        $this->_collectionClassName = "Checkout_Model_Resource_Cart_Address_Collections";
    }
}

?>