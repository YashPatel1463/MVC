<?php

class Catalog_Model_Filter extends Core_Model_Abstract
{

    public function getProductCollection()
    {
        $collection = Mage::getModel("catalog/product")
                        ->getCollection();

        $this->applyFilter($collection);
        return $collection;
    }

    public function applyFilter($collection)
    {
        $request = Mage::getSingleTon("core/request");
        $parameter = $request->getQuery();
        // echo "<pre>";
        // print_r($parameter);
        // echo "</pre>";
        // die();
        if (isset($parameter["category_id"])) {
            $collection->addCategoryFilter($parameter["category_id"]);
            unset($parameter["category_id"]);
        }

        if (!empty($parameter)) {
            $attribute_model = Mage::getModel("catalog/attribute")
                                    ->getCollection()
                                    ->addFieldToFilter("attribute_code", ["IN" => array_keys($parameter)]);

            // print_r($attribute_model->prepareQuery());
            // print_r($attribute_model->getData());
            foreach ($attribute_model->getData() as $attribute) {
                $collection->addAttributeToFilter($attribute->getAttributeCode(), $parameter[$attribute->getAttributeCode()]);
            }
        }
    }
}
