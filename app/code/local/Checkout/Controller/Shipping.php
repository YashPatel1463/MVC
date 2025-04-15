<?php

use function PHPSTORM_META\type;

// class Checkout_Controller_Shipping extends Core_Controller_Front_Action
class Checkout_Controller_Shipping extends Core_Controller_Customer_Action
{
    public function indexAction()
    {
        $layout = Mage::getBlock("core/layout");
        $index = $layout->createBlock('checkout/shipping_index');
        $layout->getChild('content')->addChild('index', $index);
        $layout->getChild('head')->addCss("checkout/shipping.css")
            ->addJs("checkout/shipping.js");
        $layout->toHtml();
    }

    public function saveAction()
    {
        $method = $this->getRequest()->getParam('shipping_method');
        $shipping = Mage::getModel("checkout/shipping")
            ->getAllShippings();

        Mage::getSingleTon("checkout/session")
            ->getCart()
            ->setShippingMethod($method)
            ->setShippingPrice($shipping[trim($method)])
            ->setPaymentMethod($this->getRequest()->getParam('payment_method'))
            ->save();
        $this->redirect("checkout/shipping/index");
    }
}
