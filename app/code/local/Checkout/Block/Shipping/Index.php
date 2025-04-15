<?php

class Checkout_Block_Shipping_Index extends Core_Block_Template {
    public function __construct()
    {
        $this->setTemplate('checkout/shipping/index.phtml');
    }

    public function getCartItems() {
        // $productData = [];
        return Mage::getSingleTon("checkout/session")
                            ->getCart()
                            ->getItemCollection()
                            ->getData();
    }

    public function getCartData() {
        return Mage::getSingleTon("checkout/session")
                            ->getCart();
    }

    public function getTotalAmount()
    {
        $items = $this->getCartItems();
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item->getSubTotal();
        }
        return $totalAmount;
    }

    public function getShippingMethods() {
        return Mage::getModel("checkout/shipping")
            ->getAllShippings();
    }

    public function getPaymentMethods() {
        return Mage::getModel("checkout/payment")
            ->getAllPayments();
    }
}

?>