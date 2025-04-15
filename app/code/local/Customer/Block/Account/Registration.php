<?php

class Customer_Block_Account_Registration extends Core_Block_Template {
    public function __construct() {
        $this->setTemplate("customer/account/registration.phtml");
    }

    public function getCustomerData() {
        $request = Mage::getModel("core/request");
        return Mage::getModel("customer/account")
            ->load($request->getQuery('customer_id'));
    }
}

?>