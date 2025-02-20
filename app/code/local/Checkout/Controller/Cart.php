<?php

class Checkout_Controller_Cart {
    public function indexAction() {
        // echo get_class() . "<br>" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $index = $layout->createBlock('checkout/cart_index')
                    ->setTemplate('checkout/cart/index.phtml');
        $layout->getChild('content')->addChild('index', $index);
        $layout->toHtml();
    }

    public function updateAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $update = $layout->createBlock('checkout/cart_update')
                    ->setTemplate('checkout/cart/update.phtml');
        $layout->getChild('content')->addChild('update', $update);
        $layout->toHtml();
    }

    public function removeAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $remove = $layout->createBlock('checkout/cart_remove')
                    ->setTemplate('checkout/cart/remove.phtml');
        $layout->getChild('content')->addChild('remove', $remove);
        $layout->toHtml();
    }

    public function addAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $add = $layout->createBlock('checkout/cart_add')
                    ->setTemplate('checkout/cart/add.phtml');
        $layout->getChild('content')->addChild('add', $add);
        $layout->toHtml();
    }
}

?>