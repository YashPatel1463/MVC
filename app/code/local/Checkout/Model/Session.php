<?php

class Checkout_Model_Session extends Core_Model_Session
{
    public function getCart()
    {
        $cartid = $this->get('cart_id');
        $cartid = is_null($cartid) ? 0 : $cartid;
        $customerId = is_null($this->get('customer_id')) ? 0 : $this->get('customer_id');
        $cart =  Mage::getModel("checkout/cart")
            ->load($cartid);
        
        if (!is_null($this->get('customer_id')) && $cart->getCustomerId() == 0) {
            $cart2 =  Mage::getModel("checkout/cart")
                ->getCollection()
                ->addFieldToFilter('customer_id', ['=' => $customerId])
                ->addFieldToFilter('is_active', ['=' => 1])
                ->getFirstItem();
                if (empty($cart->getData())) {
                    $cart->setCustomerId($customerId)
                    ->save();
                } else {
                    $cart = $cart2;
                }
        }

        if (!$cart->getCartId()) {
            // $customerId = ($this->get('customer_id')) ? $this->get('customer_id') : 0;
            // echo "12";
            // echo $customerId;
            // die;
            $cart->setCustomerId($customerId)
                ->setIsActive(1)
                ->setTotalAmount(0)
                ->setCreatedAt(date("Y-m-d H:i:s"))
                ->setUpdatedAt(date("Y-m-d H:i:s"))
                ->save();
            $this->set('cart_id', $cart->getCartId());
        }
        return $cart;
    }
}
