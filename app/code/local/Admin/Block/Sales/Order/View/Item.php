<?php

class Admin_Block_Sales_Order_View_Item extends Core_Block_Template{
    // protected $_orderBlock;

    public function __construct() {
        $this->setTemplate("admin/sales/order/view/item.phtml");
    }

    // public function setOrderBlock($order) {
    //     $this->_orderBlock = $order; 
    //     return $this;
    // }

    public function getOrderBlock() {
        // return $this->_orderBlock;
    }

    public function getItemsData() {
        return $this->getParent()->getOrderData()->getItemCollection()->getData();
    }

    public function getOrdersDetail() {
        return $this->getParent()->getOrderData();
    }

    public function getSubTotal() {
        $items = $this->getItemsData();
        $subAmount = 0;
        foreach ($items as $item) {
            $subAmount += $item->getSubTotal();
        }
        return $subAmount;
    }

}

?>