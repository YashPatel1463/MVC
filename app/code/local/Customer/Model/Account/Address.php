<?php

class Customer_Model_Account_Address extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Customer_Model_Resource_Account_Address";
        $this->_collectionClassName = "Customer_Model_Resource_Account_Address_Collections";
    }
}

?>