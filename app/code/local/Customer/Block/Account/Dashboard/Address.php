<?php

class Customer_Block_Account_Dashboard_Address extends Core_Block_Template{
    public function __construct() {
        $this->setTemplate("customer/account/dashboard/address.phtml");
    }

    public function getCustomerAddress() {
        return $this->getParent()->getCustomerData()->getAddressCollection()->getData();
    }
}

?>