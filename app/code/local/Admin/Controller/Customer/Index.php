<?php

class Admin_Controller_Customer_Index {
    public function newAction() {
        // echo __CLASS__ . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $new = $layout->createBlock('admin/customer_index_new')
                    ->setTemplate('admin/customer/index/new.phtml');
        $layout->getChild('content')->addChild('new', $new);
        $layout->toHtml();
    }
    
    public function listAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $list = $layout->createBlock('admin/customer_index_list')
                    ->setTemplate('admin/customer/index/list.phtml');
                    $layout->getChild('content')->addChild('list', $list);
                    // echo "<pre>";
                    // print_r($layout);
        $layout->toHtml();
    }

    public function saveAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $save = $layout->createBlock('admin/customer_index_save')
                    ->setTemplate('admin/customer/index/save.phtml');
        $layout->getChild('content')->addChild('save', $save);
        $layout->toHtml();
    }
    
    public function deleteAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $delete = $layout->createBlock('admin/customer_index_delete')
                    ->setTemplate('admin/customer/index/delete.phtml');
        $layout->getChild('content')->addChild('delete', $delete);
        $layout->toHtml();
    }

}

?>