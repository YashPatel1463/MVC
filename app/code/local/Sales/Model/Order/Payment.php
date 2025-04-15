<?php

class Sales_Model_Order_Payment extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Sales_Model_Resource_Order_Payment";
        $this->_collectionClassName = "Sales_Model_Resource_Order_Payment_Collections";
    }
}

?>