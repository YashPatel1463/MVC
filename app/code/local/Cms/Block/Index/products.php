<?php

class Cms_Block_Index_Products extends Core_Block_Layout{
    public function __construct() {
        $this->setTemplate("cms/index/products.phtml");
    }

    public function getProductsData(){
        return Mage::getModel("catalog/product")
            ->getCollection()
            ->leftJoin(["cmg" => "catalog_media_gallery"],"cmg.product_id = main_table.product_id", ["file_path" => "file_path", "default_image" => "default_image"])
            ->addFieldToFilter("default_image", 1)
            ->getData();
    }
}

?>