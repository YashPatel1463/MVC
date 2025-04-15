<?php

class Catalog_Block_Product_List_Products extends Catalog_Block_Product_List {
    protected $_collection;

    public function __construct() {
        $this->setTemplate("catalog/product/list/product.phtml");
        $this->init();
    }
    
    public function init()
    {
        $toolbar = $this->getLayout()->createBlock("catalog/grid_toolbar")
            ->setTemplate("catalog/grid/toolbar.phtml");

        $this->addChild("toolbar", $toolbar);

        $this->_collection =  Mage::getSingleTon("catalog/filter")
            ->getProductCollection();

        $toolbar->prepareToolbar();
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    public function getProductData()
    {
        $products = $this->getCollection()->getData();

        foreach ($products as $product) {
            $file_path = Mage::getModel("catalog/media_gallery")
                ->getCollection()
                ->select("file_path")
                ->addFieldToFilter("product_id", $product->getProductId())
                ->addFieldToFilter("default_image", 1)
                ->getFirstItem();

            $product->setFilePath($file_path->getFilePath());
        }
        return $products;
    }
}


?>