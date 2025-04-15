<?php

class Checkout_Model_Payment extends Core_Model_Abstract
{
    public function getAllPayments()
    {
        $paymentMethods = [
            "Cash On Delivery",
            "Paypal"
        ];
        return $paymentMethods;
    }
}

?>