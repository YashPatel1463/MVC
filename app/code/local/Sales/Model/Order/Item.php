<?php

class Sales_Model_Order_Item extends Core_Model_Abstract {
    
    public function init() {
        $this->_resourceClassName = "Sales_Model_Resource_Order_Item";
        $this->_collectionClassName = "Sales_Model_Resource_Order_Item_Collections";
    }

    public function getProduct() {
        $_product = [];
        return Mage::getModel("catalog/product")
            ->load($this->getProductId());
    }
}

?>