<?php

use function PHPSTORM_META\type;

// class Checkout_Controller_Cart extends Core_Controller_Front_Action{
class Checkout_Controller_Cart extends Core_Controller_Customer_Action
{
    public function indexAction()
    {
        // echo get_class() . "<br>" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $index = $layout->createBlock('checkout/cart_index');
        $layout->getChild('content')->addChild('index', $index);
        $layout->getChild('head')->addCss("checkout/cart.css")
            ->addJs("checkout/cart.js");
        $layout->toHtml();
    }


    public function updateAction()
    {
        $itemid = $this->getRequest()->getQuery('update_id');
        $quantity = $this->getRequest()->getQuery('qty');

        
        Mage::getModel("checkout/session")
            ->getCart()
            ->updateItem($itemid, $quantity)
            ->save();

        $this->redirect("checkout/cart/index");
    }

    public function removeAction()
    {
        $itemid = $this->getRequest()->getQuery('delete_id');
        $cart = Mage::getModel("checkout/session")
            ->getCart();
        $cart->removeItem($itemid)->save();
        // die;
        $this->getMessage()
            ->addSuccess('Product Removed from Cart.');
        $this->redirect("checkout/cart/index");
    }

    public function addAction()
    {
        $data = $this->getRequest()->getParam('cart');
        Mage::getModel("checkout/session")
            ->getCart()
            ->addProduct($data['product_id'], $data['quantity'])
            ->save();
        $this->getMessage()
            ->addSuccess('Product Added to Cart Successfully.');
        $this->redirect('catalog/product/view?product_id='.$data['product_id']);
    }

    public function applyCouponAction()
    {
        $coupon = $this->getRequest()->getParam('coupon');

        if ($coupon['type'] == "remove") {
            $coupon['coupon_code'] = "";
            $this->getMessage()
                ->addWarning('Coupon Removed.');
        } else {
            $this->getMessage()
                ->addSuccess('Coupon Applied.');
        }

        $discount = Mage::getModel("checkout/coupon")->calculateDiscount($coupon['coupon_code'], $coupon['subTotal']);

        $cart = Mage::getSingleTon("checkout/session")
            ->getCart();

        if ($discount) {
            $cart->setCouponCode($coupon['coupon_code']);
        } else {
            $cart->setCouponCode("");
        }
        $cart->setCouponDiscount($discount)
            ->save();

        // die;
        $this->redirect("checkout/cart/index");
    }

    public function testAction()
    {
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        $itemCollection = Mage::getSingleTon("checkout/session")
            ->getCart()
            ->getItemCollection()
            ->select(["subtotal" => "SUM(main_table.sub_total)", "item_id"]);

        Mage::log($itemCollection->prepareQuery());
    }
}
