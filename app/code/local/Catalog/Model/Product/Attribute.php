<?php

class Catalog_Model_Product_Attribute extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Catalog_Model_Resource_Product_Attribute";
        $this->_collectionClassName = "Catalog_Model_Resource_Product_Attribute_Collections";
    }
}

?>