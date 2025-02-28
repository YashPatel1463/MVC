<?php

class Admin_Block_Category_Index_List extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('admin/category/index/list.phtml');
    }

    public function getCategoriesData()
    {
        $category = Mage::getModel('catalog/category')
                        ->getCollection();
        return $category->getData();
    }   
}
