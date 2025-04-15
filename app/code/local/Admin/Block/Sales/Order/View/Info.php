<?php

class Admin_Block_Sales_Order_View_Info extends Core_Block_Template{
    // protected $_orderBlock;
    public function __construct() {
        $this->setTemplate("admin/sales/order/view/info.phtml");
    }

    // public function setOrderBlock($order) {
    //     $this->_orderBlock = $order; 
    //     return $this;
    // }

    public function getOrdersDetail() {
        return $this->getParent()->getOrderData();
        // return $this->_orderBlock->getOrderData();
    }
}

?>