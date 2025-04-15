<?php

class Checkout_Controller_Order extends Core_Controller_Customer_Action
{
    public function placeOrderAction()
    {
        $cart = Mage::getSingleTon("checkout/session")
            ->getCart();
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";

        if ($cart->getPaymentMethod() == 'Paypal') {
            $this->redirect('paypal/transaction/start');
        } else {
            $this->redirect('checkout/order/convert');
        }

        // die;

    }

    public function convertAction()
    {

        // echo "<pre>";
        // print_r($_GET);
        // echo "</pre>";
        // die;
        $tran_id = $this->getRequest()->getQuery('transaction_id');
        $cart = Mage::getSingleTon("checkout/session")
            ->getCart();
        $order = Mage::getModel("checkout/convert_order")
            ->convert($cart);

        Mage::getModel('sales/order_payment')
            ->setOrderId($order->getOrderId())
            ->setAmount($order->getTotalAmount())
            ->setPaymentMethod($order->getPaymentMethod())
            ->setTransactionId($tran_id)
            ->setStatus('completed')
            ->save();

        $cart->setIsActive(0)
            ->save();
        Mage::getSingleTon("core/session")
            ->remove('cart_id');

        $this->getMessage()
            ->addSuccess('Order Placed Successfully.');
        $this->redirect("");
    }
}
