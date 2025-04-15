<?php

class Customer_Block_Account_Dashboard_Info extends Core_Block_Template{
    public function __construct() {
        $this->setTemplate("customer/account/dashboard/info.phtml");
    }

    public function getCustomerData() {
        return $this->getParent()->getCustomerData();
    }
}

?>