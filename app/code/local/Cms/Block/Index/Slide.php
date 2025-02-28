<?php

class Cms_Block_Index_Slide extends Core_Block_Layout{
    public function __construct() {
        $this->setTemplate("cms/index/slider.phtml");
    }

    public function getProductData(){
        $class = Mage::getModel("catalog/product");
        $data = $class->getCollection()
                      ->select("name,price,description")
                      ->leftJoin(["cmg" => "catalog_media_gallery"],"cmg.product_id = main_table.product_id", ["file_path" => "file_path"])
                      ->groupBy(["name"])
                      ->limit(10);
        return $data->getData();
    }
}

?>