<?php

class Customer_Block_Account_Order_List extends Core_Block_Template {
    public function __construct() {
        $this->setTemplate("customer/account/order/list.phtml");
    }

    public function getOrderData() {
        $session = Mage::getSingleTon("core/session");
        return Mage::getModel("sales/order")
            ->getCollection()
            ->addFieldToFilter('customer_id',$session->get('customer_id'))
            ->getData();
    }
}

?>