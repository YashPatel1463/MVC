<?php

class Checkout_Block_Cart_Index extends Core_Block_Template {
    public function __construct()
    {
        $this->setTemplate('checkout/cart/index.phtml');
    }

    public function getCartItems() {
        $productData = [];
        $session_model = Mage::getSingleTon("checkout/session")
                            ->getCart();
        // echo "in block";
        // echo "<pre>";
        $items = $session_model->getItemCollection();

        // print_r($items->getData());

        // foreach($items->getData() as $item) {
            // $productData[] = array_merge($item->getData(), $item->getProduct()->getData()); 
            
            // print_r($item->getProduct());
        // }
        // print_r($productData);
        // echo "</pre>";

        return $items->getData();
    }

    public function getCartData() {
        return Mage::getSingleTon("checkout/session")
                            ->getCart();
                            
        // return Mage::getModel("checkout/cart")
        //             ->getCollection()
        //             ->addFieldToFilter("cart_id",)
        //         ->load($this->getFirstItem()->getCartId());
        // echo "<pre>";
        // print_r($a);
        // echo "</pre>";
        // die;
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
}

?>