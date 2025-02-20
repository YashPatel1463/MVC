<?php

class Admin_Controller_Customer_Address {
    public function newAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $new = $layout->createBlock('admin/customer_address_new')
                    ->setTemplate('admin/customer/address/new.phtml');
        $layout->getChild('content')->addChild('new', $new);
        $layout->toHtml();
    }

    public function listAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $list = $layout->createBlock('admin/customer_address_list')
                    ->setTemplate('admin/customer/address/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }

    public function saveAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $save = $layout->createBlock('admin/customer_address_save')
                    ->setTemplate('admin/customer/address/save.phtml');
        $layout->getChild('content')->addChild('save', $save);
        $layout->toHtml();
    }
    
    public function deleteAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $delete = $layout->createBlock('admin/customer_address_delete')
                    ->setTemplate('admin/customer/address/delete.phtml');
        $layout->getChild('content')->addChild('delete', $delete);
        $layout->toHtml();
    }

}

?>