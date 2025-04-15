<?php

class Admin_Controller_Category_Index extends Core_Controller_Admin_Action {
    protected $_allowedActions = [];
    public function newAction() {
        $layout = Mage::getBlock("core/layout");
        $new = $layout->createBlock("admin/category_index_new");
        $layout->getChild('content')->addChild('new',$new);

        $layout->toHtml();
    }

    public function saveAction() {
        $request = Mage::getModel("core/request");
        $data = $request->getParam("catalog_category");
        $category = Mage::getModel("catalog/category");
        $category->setData($data);

        $id = $category->save();
        
        $this->getMessage()
            ->addSuccess('New Category Added.');
        header("location: http://localhost/mvcproject/admin/category_index/list");
    }

    public function listAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  $this->getLayout();
        $list = $layout->createBlock('admin/category_index_list');
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addCss('admin/sales/order/list.css');
        $layout->toHtml();
    }

    public function deleteAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $request = Mage::getModel("core/request");
        $category = Mage::getModel('catalog/category');

        // $product->setData($data);
        $class = Mage::getModel('core/request');
        $id = $class->getQuery('delete_id');
        // echo $id;
        $category->load($id);

        $id = $category->delete();
        
        $this->getMessage()
            ->addSuccess('Category Deleted.');

        header("location: http://localhost/mvcproject/admin/category_index/list");
    }
}

?>