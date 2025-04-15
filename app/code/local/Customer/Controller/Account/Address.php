<?php

class Customer_Controller_Account_Address extends Core_Controller_Customer_Action
{

    protected $_allowedActions = [];

    public function newAction()
    {
        // echo get_class() . "<br>" . __FUNCTION__;
        $layout =  $this->getLayout();
        $new = $layout->createBlock('customer/account_address_new');
        $layout->getChild('content')->addChild('new', $new);
        $layout->getChild('head')->addCss('customer/account/address/new.css');
        $layout->toHtml();
    }

    public function saveAction()
    {
        $session = Mage::getSingleTon("core/session");

        $customerAddress = $this->getRequest()->getParam('customer_address');

        Mage::getModel("customer/account_address")
            ->setData($customerAddress)
            ->setCustomerId($session->get('login'))
            ->save();

        $this->getMessage()
            ->addSuccess('New Address Added.');

        $this->redirect("customer/account/dashboard");
    }

    public function setDefaultAction()
    {
        $session = Mage::getSingleTon("core/session");
        $address = Mage::getModel("customer/account_address");

        $oldDefaultAddress = $address->getCollection()
            ->addFieldToFilter("customer_id", $session->get('login'))
            ->addFieldToFilter('default_address', '1')
            ->getFirstItem();

        if (!empty($oldDefaultAddress->getData())) {
            $oldDefaultAddress->setDefaultAddress(0)
                ->save();
        }

        $address->load($this->getRequest()->getQuery('address_id'))
            ->setDefaultAddress(1)
            ->save();

        $this->redirect("customer/account/dashboard");
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getQuery('delete_id');
        Mage::getModel("customer/account_address")
            ->load($id)
            ->delete();

        $this->getMessage()
            ->addSuccess('Address Deleted Successfully.');

        $this->redirect("customer/account/dashboard");
    }
}
