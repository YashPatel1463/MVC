<?php

class Checkout_Block_Address_Index extends Core_Block_Template {
    public function __construct()
    {
        $this->setTemplate('checkout/address/index.phtml');
    }

    public function getEmail() {
        return Mage::getSingleTon("checkout/session")
            ->getCart()
            ->getCustomerEmail();
    }

    public function getBillingData() {
        return Mage::getSingleTon("checkout/session")
           ->getCart()
           ->getBillingAddress();
    }

    public function getShippingData() {
        return Mage::getSingleTon("checkout/session")
            ->getCart()
            ->getShippingAddress();
    }
}

?>