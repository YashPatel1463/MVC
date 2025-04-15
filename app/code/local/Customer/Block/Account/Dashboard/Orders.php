<?php

class Customer_Block_Account_Dashboard_Orders extends Core_Block_Template{
    public function __construct() {
        $this->setTemplate("customer/account/dashboard/orders.phtml");
    }

    public function getOrderData() {
        return $this->getParent()->getCustomerData()->getOrderCollection()->getData();
    }
}

?>