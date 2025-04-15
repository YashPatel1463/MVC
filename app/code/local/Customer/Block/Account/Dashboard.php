<?php

class Customer_Block_Account_Dashboard extends Core_Block_Template {
    protected $_customerData = null;
    public function __construct() {
        $this->setTemplate("customer/account/dashboard.phtml");
    }
    
    public function setCustomerData($customer) {
        $this->_customerData = $customer;
        return $this;
    }

    public function getCustomerData() {
        return $this->_customerData;
    }
}

?>