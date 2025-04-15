<?php

class Admin_Block_Category_Index_New extends Core_Block_Layout {
    public function __construct() {
        $this->setTemplate("admin/category/index/new.phtml");
    }

    public function getCategories() {
        $category = Mage::getModel('catalog/category')
                        ->getCollection();
        return $category->getData();
    }

    public function getCategory() {
        $request = Mage::getModel("core/request");
        $id = $request->getQuery("edit_id");
        $category = Mage::getModel('catalog/category')
                        ->load($id);
        return $category;
    }
}

?>