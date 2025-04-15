<?php

class Customer_Block_Account_Address_New extends Core_Block_Template {
    public function __construct() {
        $this->setTemplate("customer/account/address/new.phtml");
    }

    public function getAddressData() {
        $request = Mage::getModel("core/request");
        return Mage::getModel("customer/account_address")
            ->load($request->getQuery('address_id'));
    }
}

?>