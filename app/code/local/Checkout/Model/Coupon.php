<?php

class Checkout_Model_Coupon extends Core_Model_Abstract
{
    public function getAllCoupons()
    {
        $coupons = [
            'BAG25' => '25%',
            'YASH10' => '10%',
            'LAP200' => '200',
            'SAVE5' => '5%',
            'DEAL30' => '30%',
            'NEWYEAR20' => '20%',
            'FESTIVE500' => '500',
            'SUPERDEAL15' => '15%',
            'GADGET3000' => '3000',
        ];
        return $coupons;
    }

    public function calculateDiscount($couponCode, $subTotal)
    {
        if (array_key_exists($couponCode, $this->getAllCoupons())) {
            $discountValue = $this->getAllCoupons()[$couponCode];

            if ((str_contains($discountValue, '%'))) {
                $discount = $subTotal * (floatval(str_replace('%', '', $discountValue)) / 100);
            } else {
                $discount = floatval($discountValue);
            }
        } else {
            $discount = 0;
        }
        // die;
        return $discount;
    }
}
