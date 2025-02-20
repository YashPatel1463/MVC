<?php

class Admin_Block_Product_Index_List extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('admin/product/index/list.phtml');
    }

    public function getroductsData()
    {
        $product = Mage::getModel('catalog/product')
            ->getCollection()
            ->select("catlog_product.*")
            ->leftJoin("catlog_category","catlog_category.category_id = catlog_product.category_id", ["category_name" => "name","category_image"=>"image"]);
        return $product->getData();
    }   
}
