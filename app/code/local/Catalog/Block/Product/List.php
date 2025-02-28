<?php

class Catalog_Block_Product_List extends Core_Block_Template {
    public function __construct()
    {
        $this->setTemplate('catalog/product/List.phtml');
    }

    public function getProductData()
    {
        $request = Mage::getModel("core/request");
        $id = $request->getQuery('category_id');
        $product = Mage::getModel('catalog/product')
                        ->getCollection()
                        ->select("product_id,name,price,description")
                        ->addFieldToFilter("category_id",$id)
                        ->leftJoin(["cmg" => "catalog_media_gallery"],"cmg.product_id = main_table.product_id", ["file_path" => "file_path"])
                        ->groupBy(["main_table.product_id"]);

        return $product->getData();
    }
}

?>