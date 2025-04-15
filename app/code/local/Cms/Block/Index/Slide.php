<?php

class Cms_Block_Index_Slide extends Core_Block_Layout{
    public function __construct() {
        $this->setTemplate("cms/index/slider.phtml");
    }

    public function getProductData(){
        return Mage::getModel("catalog/product")
            ->getCollection()
            ->select("product_id,name,price,description")
            ->leftJoin(["cmg" => "catalog_media_gallery"],"cmg.product_id = main_table.product_id", ["file_path" => "file_path", "default_image" => "default_image"])
            ->addFieldToFilter("default_image", 1)
            ->limit(10)
            ->getData();
    }
}

?>