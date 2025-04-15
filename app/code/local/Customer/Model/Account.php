<?php

class Customer_Model_Account extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Customer_Model_Resource_Account";
        $this->_collectionClassName = "Customer_Model_Resource_Account_Collections";
    }

    protected function _afterSave()
    {
        $address=Mage::getModel("customer/account_address")->getCollection()->addFieldToFilter("customer_id",["="=>$this->getCustomerId()])->getData();
        // Mage::log($address);
        // die;
        if(isset($address[0]))
        {
            
        }
        else{
            $address=Mage::getModel("customer/account_address")
                ->setFirstname($this->getFirstName())
                ->setLastname($this->getLastName())
                ->setPhone($this->getPhone())
                ->setCustomerId($this->getCustomerId())
                ->setStreet($this->getStreet())
                ->setCity($this->getCity())
                ->setState($this->getState())
                ->setCountry($this->getCountry())
                ->setZipCode($this->getZipCode())
                ->setAddressType($this->getAddressType())
                ->setDefaultAddress(1)
                ->setCreatedAt(date("Y-m-d H:i:s"))
                ->save();
        }
    }

    public function getOrderCollection() {
        return Mage::getModel("sales/order")
            ->getCollection()
            ->addFieldToFilter('customer_id',$this->getCustomerId());
    }

    public function getAddressCollection() {
        return Mage::getModel("customer/account_address")
            ->getCollection()
            ->addFieldToFilter('customer_id',$this->getCustomerId());
    }
}

?>