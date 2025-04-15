<?php

class Admin_Block_Sales_Order_View extends Core_Block_Template {
    protected $_orderData = null;

    public function __construct()
    {
        $this->setTemplate('admin/sales/order/view.phtml');
    }

    public function setOrderData($order) {
        $this->_orderData = $order;
        return $this;
    }

    public function getOrderData() {
        return $this->_orderData;
    }
}

?>