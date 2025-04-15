<?php

class Sales_Model_Order_Address extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Sales_Model_Resource_Order_Address";
        $this->_collectionClassName = "Sales_Model_Resource_Order_Address_Collections";
    }
}

?>