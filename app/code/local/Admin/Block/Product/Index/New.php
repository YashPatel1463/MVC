<?php

class Admin_Block_Product_Index_New extends Core_Block_Template {
    public function __construct() {
        $this->setTemplate('admin/product/index/new.phtml');
    }

    public function getProductData() {
        $class = Mage::getModel('core/request');
        // echo "<pre>";
        // print_r($class);
        $id = $class->getQuery('edit_id');
        // echo $id;
        return Mage::getModel('catalog/product')
                    ->load($id);
                        // print_r($data);
                        // echo "</pre>";
    }
    
    public function getCategoryData()
    {
        $product = Mage::getModel('catalog/category')
            ->getCollection()
            ->addFieldToFilter("parent_id",[">="=>"1"]);
        return $product->getData();
    }

    public function getAttributeData()
    {
        $attributes = Mage::getModel('catalog/attribute')
            ->getCollection();
        return $attributes->getData();
    }

    

    public function getHtmlField($field, $data) {
        $field = ucfirst(strtolower($field));
        $className = sprintf("Admin_Block_Html_Elements_%s",$field);

        $element = new $className($data);
        return $element->render();
    }
}

?>