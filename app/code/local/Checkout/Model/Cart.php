<?php

class Checkout_Model_Cart extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = "Checkout_Model_Resource_Cart";
        $this->_collectionClassName = "Checkout_Model_Resource_Cart_Collections";
    }

    public function addProduct($product_id, $quantity)
    {
        // echo $this->getCartId();
        // echo "in addproduct";
        // die();
        Mage::getModel("checkout/cart_item")
            ->setCartId($this->getCartId())
            ->setProductId($product_id)
            ->setProductQuantity($quantity)
            ->save();
        return $this;
    }

    protected function _beforeSave()
    {
        // echo "<pre>";
        // print_r($this);
        // echo "</pre>";
        $subtotal = 0;
        foreach ($this->getItemCollection()->getData() as $cartitem) {
            $subtotal += $cartitem->getSubTotal();
        }

        $discount = Mage::getModel("checkout/coupon")->calculateDiscount($this->getCouponCode(), $subtotal);

        $this->setCouponDiscount($discount);

        $subtotal -= $this->getCouponDiscount();
        $subtotal += ($this->getShippingPrice() != null) ? $this->getShippingPrice() : 0;
        
        $this->setTotalAmount($subtotal);
        $this->setUpdatedAt(date("Y-m-d H:i:s"));
    }

    public function getItemCollection()
    {
        return Mage::getModel("checkout/cart_item")
            ->getCollection()
            ->addFieldToFilter("cart_id", $this->getCartId());
    }

    public function getAddressCollection()
    {
        return Mage::getModel("checkout/cart_address")
            ->getCollection()
            ->addFieldToFilter("cart_id", $this->getCartId());
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

    public function removeItem($itemid) {
        foreach ($this->getItemCollection()->getData() as $item) {
            if($item->getItemId() == $itemid) {
                $item->delete();
            }
        }
        return $this;
    }

    public function updateItem($itemid, $quantity) {
        foreach ($this->getItemCollection()->getData() as $item) {
            if($item->getItemId() == $itemid) {
                // echo "<pre>";
                // print_r($item);
                // echo "</pre>";
                $item->setProductQuantity($quantity)
                    ->save();
            }
        }
        return $this;
    }
}
