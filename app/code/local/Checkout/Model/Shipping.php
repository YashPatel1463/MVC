<?php

class Checkout_Model_Shipping extends Core_Model_Abstract
{
    public function getAllShippings()
    {
        $shippingMethods = [
            "Free Shipping" => 0,
            "Standard Shipping" => 6,
            "Express Shipping" => 13,
            "Overnight Shipping" => 25
        ];
        return $shippingMethods;
    }
}

?>