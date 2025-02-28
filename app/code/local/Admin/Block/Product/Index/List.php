<?php

class Admin_Block_Product_Index_List extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('admin/product/index/list.phtml');
    }

    public function getProductsData()
    {
        $product = Mage::getModel('catalog/product')
                        ->getCollection()
                        ->addAttributeToSelect(["color", "weight","material", "warranty", "manufacturer", "countryoforigin"]);
                        // ->select("catlog_product.*")
                        // ->leftJoin("catlog_category","catlog_category.category_id = catlog_product.category_id", ["category_name" => "name","category_image"=>"image"]);
        // echo "<pre>";
        // print_r($product->getData());
        // echo "</pre>";
        return $product->getData();
    }   

    public function getAttributes() {
        $attribute = Mage::getModel('catalog/attribute')
                            ->getCollection();
        return $attribute->getData();
    }
}
