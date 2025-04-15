<?php

class Admin_Block_Sales_Order_View_Address extends Core_Block_Template{
    // protected $_orderBlock;
    public function __construct() {
        $this->setTemplate("admin/sales/order/view/address.phtml");
    }

    // public function setOrderBlock($order) {
    //     $this->_orderBlock = $order; 
    //     return $this;
    // }

    public function getBillingAddress() {
        return $this->getParent()->getOrderData()->getBillingAddress();
    }

    public function getShippingAddress() {
        return $this->getParent()->getOrderData()->getShippingAddress();
    }

}

?>