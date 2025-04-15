<?php

class Catalog_Model_Resource_Product_Collections extends Core_Model_Resource_Collection_Abstract{
    public function addAttributeToSelect($attributes) {
    
        foreach($attributes as $attribute) {
            $a = Mage::getModel("catalog/attribute")
                    ->load($attribute, "attribute_code");
            $attribute_id = $a->getAttributeId();
            $this->leftJoin(
                ["cpa_{$a->getAttributeCode()}" => "catalog_product_attribute"],
                "main_table.product_id=cpa_{$a->getAttributeCode()}.product_id AND cpa_{$a->getAttributeCode()}.attribute_id={$attribute_id}",
                [$a->getAttributeCode() => "value"]);

            // echo "<pre>";
            // print_r($a);
            // echo "</pre>";
        }
        // die();
        
        return $this;
    }

    public function addCategoryFilter($category_id) {
        $this->addFieldToFilter("category_id",["=" => $category_id]);
        return $this;
    }

    public function addAttributeToFilter($attribute, $value) {
        $this->addAttributeToSelect([$attribute]);
        
        if(str_contains($value, ",")) {
            $this->addFieldToFilter("cpa_".$attribute.".value", ["in" => explode(",", $value)]);
            // $this->addFieldToFilter("cpa_".$attribute.".value", ["in" => [implode("', '", explode(",", $value))]]);
        } else {
            $this->addFieldToFilter("cpa_".$attribute.".value", $value);
        }
            
        return $this;
    }
}

?>