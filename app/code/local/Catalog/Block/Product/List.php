<?php

class Catalog_Block_Product_List extends Core_Block_Template
{
    public function __construct()
    {
        $filter = $this->getLayout()->createBlock("catalog/product_list_filter");
        $products = $this->getLayout()->createBlock("catalog/product_list_products");

        $this->addChild('filter', $filter);
        $this->addChild('products', $products);
        
        $this->setTemplate("catalog/product/list.phtml");
    }

    public function getAttributesData()
    {
        $product_attribute_model = Mage::getModel("catalog/product_attribute")
            ->getCollection();

        $data = $product_attribute_model->getData();

        $attribute_model = Mage::getSingleTon("catalog/attribute")
            ->getCollection()
            ->getData();

        foreach ($attribute_model as $key => $attribute) {
            $uniqueValues[$attribute->getAttributeCode()] =  $this->uniqueValues($data, $attribute->getAttributeId());
        }
        return $uniqueValues;
    }

    public function uniqueValues($data, $attribute_id)
    {
        $values = array_map(fn($attr) => ($attr->getAttributeId() == $attribute_id) ? $attr->getValue() : "", $data);
        return array_values(array_unique(array_filter($values)));
    }
}
