<?php

use function PHPSTORM_META\type;

// class Checkout_Controller_Address extends Core_Controller_Front_Action{    
class Checkout_Controller_Address extends Core_Controller_Customer_Action{    
    public function updateAction() {
       
    }

    public function indexAction() {
        $layout = Mage::getBlock("core/layout");
        $index = $layout->createBlock('checkout/address_index');
        $layout->getChild('content')->addChild('index', $index);
        $layout->getChild('head')->addCss("checkout/address.css")
            ->addJs("checkout/address.js");
        $layout->toHtml();
    }

    public function saveAction() {
        // $this->getRequest()->getParam('customer');
        // echo "<pre>";
        // print_r($this->getRequest()->getParam('billing'));
        // print_r($this->getRequest()->getParam('shipping'));
        // echo "</pre>";
        // die;
        $cart = Mage::getSingleTon("checkout/session")
                ->getCart();
        
        $address = Mage::getModel("checkout/cart_address");
        $address->setData($this->getRequest()->getParam('billing'));
        $address->setCartId($cart->getCartId())
            ->setCreatedAt(date("Y-m-d H:i:s"))
            ->save();

        $address->setData($this->getRequest()->getParam('shipping'));
        $address->setCartId($cart->getCartId())
            ->setCreatedAt(date("Y-m-d H:i:s"))
            ->save();

        $cart->setCustomerEmail($this->getRequest()->getParam('customer_email'))
            ->save();
        
        $this->redirect("checkout/shipping/index");
    }
}

?>