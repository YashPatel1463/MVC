<?php

class Catalog_Block_Product_View extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('catalog/product/view.phtml');
    }

    public function getProductData()
    {
        $request = Mage::getModel("core/request");
        $id = $request->getQuery('product_id');
        $product = Mage::getModel('catalog/product')
            ->load($id);

        // ->getCollection()
        // ->select("catalog_product.product_id,name,price,description")
        // ->addFieldToFilter("product_id", $id);
        // ->join("catalog_media_gallery","catalog_media_gallery.product_id = catalog_product.product_id", ["file_path" => "file_path"]);
        // ->groupBy(["catalog_product.product_id"]);        
        return $product;
    }

    public function getAttributes()
    {
        $attributes = Mage::getModel("catalog/Attribute")
            ->getCollection();

        return $attributes->getData();
    }

    public function getReviews()
    {
        return Mage::getModel('catalog/product_review')
            ->getCollection()
            ->addFieldToFilter('product_id', $this->getRequest()->getQuery('product_id'))
            ->join(['c' => 'customer'], "c.customer_id = main_table.customer_id", ["fname" => "first_name", "lname" => "last_name"])
            ->getData();
            // ->prepareQuery();
            // ->leftJoin(["attr" => "catalog_attribute"], "attr.attribute_id = main_table.attribute_id", ["name" => "attribute_code"]);
    }

    // public function getUser()
    // {
    //     $data = $this->getReviews();
    //     foreach ($data as $_data) {
    //         $name = Mage::getModel('customer/account')
    //             ->load($_data->getCutomerId());
    //         // Mage::log($name);
    //         // $this->getReviews()
    //             // ->setCustomer($name);
    //     }
    //     return $this->getReviews();
    // }
}
