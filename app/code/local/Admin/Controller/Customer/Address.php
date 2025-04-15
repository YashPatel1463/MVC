<?php

class Admin_Controller_Customer_Address extends Core_Controller_Admin_Action {
    public function newAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  $this->getLayout();
        $new = $layout->createBlock('admin/customer_address_new')
                    ->setTemplate('admin/customer/address/new.phtml');
        $layout->getChild('content')->addChild('new', $new);
        $layout->toHtml();
    }

    public function listAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  $this->getLayout();
        $list = $layout->createBlock('admin/customer_address_list')
                    ->setTemplate('admin/customer/address/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }

    public function saveAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  $this->getLayout();
        $save = $layout->createBlock('admin/customer_address_save')
                    ->setTemplate('admin/customer/address/save.phtml');
        $layout->getChild('content')->addChild('save', $save);
        $layout->toHtml();
    }
    
    public function deleteAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  $this->getLayout();
        $delete = $layout->createBlock('admin/customer_address_delete')
                    ->setTemplate('admin/customer/address/delete.phtml');
        $layout->getChild('content')->addChild('delete', $delete);
        $layout->toHtml();
    }

}

?>