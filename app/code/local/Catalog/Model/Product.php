<?php

class Catalog_Model_Product extends Core_Model_Abstract
{
    public $status = [0 => "Disable", 1 => "Enable"];
    public function init()
    {
        $this->_resourceClassName = "Catalog_Model_Resource_Product";
        $this->_collectionClassName = "Catalog_Model_Resource_Product_Collections";
    }

    public function getStatusText()
    {
        return isset($this->status[$this->getStatus()]) ? $this->status[$this->getStatus()] : "NA";
    }

    protected function _afterLoad()
    {
        if ($this->getProductId()) {
            $collection = Mage::getModel("catalog/product_attribute")
                        ->getCollection()
                        ->addFieldToFilter("product_id", $this->getProductId())
                        ->leftJoin(["attr" => "catalog_attribute"], "attr.attribute_id = main_table.attribute_id", ["name" => "attribute_code"]);

            $imagescollection = Mage::getModel("catalog/media_gallery")
                                    ->getCollection()
                                    ->addFieldToFilter("product_id", $this->getProductId());

            // echo "<pre>";
            // print_r($collection->getData());
            // print_r($imagescollection->getData());
            // echo "</pre>";
            
            foreach ($collection->getData() as $_data) {
                $this->{$_data->getName()} = $_data->getValue();
            }

            $filepaths = [];

            foreach ($imagescollection->getData() as $image) {
                $filepaths[] = $image->getFilePath();
            }

            $this->_data['file_path'] = $filepaths;

            // echo "<pre>";
            // print_r($collection->getData());
            // echo "</pre>";
        }
        // echo "<pre>";
        // print_r($this);
        // echo "</pre>";
        return $this;
    }
}
