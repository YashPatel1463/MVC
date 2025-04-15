<?php

class Checkout_Model_Convert_Order
{
    public function convert($cart)
    {
        $cartData = $cart->getData();
        unset($cartData['cart_id']);
        unset($cartData['created_at']);
        unset($cartData['updated_at']);
        unset($cartData['is_active']);

        if (ctype_alpha(substr($cartData['customer_email'], 0, 3))) {
            $email = strtoupper(substr($cartData['customer_email'], 0, 3));
        } else {
            $email = "ORD";
        }

        $orderno = $cartData['customer_id'] . $email . date("Ymd");
        $order = Mage::getModel("sales/order")
            ->setData($cartData)
            ->setIpAddress($_SERVER['REMOTE_ADDR'])
            ->setOrderNo($orderno)
            ->save();

        $order_id = $order->getOrderId();
        $cartItem = $cart->getItemCollection()
            ->getData();

        foreach ($cartItem as $item) {
            $itemData = $item->getData();
            unset($itemData['item_id']);
            unset($itemData['cart_id']);
            unset($itemData['is_active']);
            Mage::getModel("sales/order_item")
                ->setData($itemData)
                ->setOrderId($order_id)
                ->save();
        }

        $billAddress = $cart->getBillingAddress()->getData();
        unset($billAddress['address_id']);
        unset($billAddress['cart_id']);
        unset($billAddress['is_active']);
        unset($billAddress['created_at']);
        unset($billAddress['updated_at']);
        Mage::getModel("sales/order_address")
            ->setData($billAddress)
            ->setOrderId($order_id)
            ->save();

        $shipAddress = $cart->getShippingAddress()->getData();
        unset($shipAddress['address_id']);
        unset($shipAddress['cart_id']);
        unset($shipAddress['is_active']);
        unset($shipAddress['created_at']);
        unset($shipAddress['updated_at']);
        Mage::getModel("sales/order_address")
            ->setData($shipAddress)
            ->setOrderId($order_id)
            ->save();

        return $order;
    }
}

?>