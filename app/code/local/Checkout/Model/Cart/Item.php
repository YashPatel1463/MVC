<?php

class Checkout_Model_Cart_Item extends Core_Model_Abstract {
    protected $_data = [];
    public function init() {
        $this->_resourceClassName = "Checkout_Model_Resource_Cart_Item";
        $this->_collectionClassName = "Checkout_Model_Resource_Cart_Item_Collections";
    }

    protected function _beforeSave()
    {
        Mage::log($this);
        $cart_item = $this->getCollection()
            ->addFieldtoFilter('cart_id', $this->getCartId())
            ->addFieldtoFilter('product_id', $this->getProductId())
            ->getFirstItem();
            // ->getData();

        // echo "<pre>";
        // print_r($this);
        // print_r($cart_item);
        // echo "</pre>";
        // die;
        

        if ($cart_item->getItemId()) { // Check if the item exists
            // echo "Updating quantity...";
            
            // If updating, set the new quantity <inste></inste>ad of adding
            if ($this->getItemId()) { // If item ID exists, it's an update
                $this->setProductQuantity($this->getProductQuantity()); 
                echo "<pre>";
                print_r($this);
                echo "</pre>";
            } else { // If it's a duplicate entry, increase the quantity
                $this->setProductQuantity($cart_item->getProductQuantity() + $this->getProductQuantity());
                $this->setItemId($cart_item->getItemId()); 
            }
        } 
        // die;
    //     if (!empty($cart_item)) {
    //         echo "double qty";
    //         die;
    //         $this->setProductQuantity($cart_item[0]->getProductQuantity() + $this->getProductQuantity());
    //         $this->setItemId($cart_item[0]->getItemId());
    //     }
    //     // echo "<pre>";
    //     // print_r($this);
    //     // echo "</pre>";
    //     // die;
        $price = Mage::getModel('catalog/product')->load($this->getProductId())->getPrice();
        $this->setPrice($price);
        $this->setSubTotal($price * $this->getProductQuantity());
    }

    public function getProduct() {
        $_product = [];
        return Mage::getModel("catalog/product")
            ->load($this->getProductId());
    }
}

?>