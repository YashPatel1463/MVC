<?php

class Sales_Model_Order extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = "Sales_Model_Resource_Order";
        $this->_collectionClassName = "Sales_Model_Resource_Order_Collections";
    }

    public function getItemCollection()
    {
        return Mage::getModel("sales/order_item")
            ->getCollection()
            ->addFieldToFilter("order_id", $this->getOrderId());
    }

    public function getAddressCollection()
    {
        return Mage::getModel("sales/order_address")
            ->getCollection()
            ->addFieldToFilter("order_id", $this->getOrderId());
    }

    public function getBillingAddress() {
        return $this->getAddressCollection()
            ->addFieldToFilter('address_type','billing')
            ->getFirstItem();
    }

    public function getShippingAddress() {
        return $this->getAddressCollection()
            ->addFieldToFilter('address_type','shipping')
            ->getFirstItem();
    }
}


?>
