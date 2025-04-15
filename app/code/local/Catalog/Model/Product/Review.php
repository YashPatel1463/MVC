<?php

class Catalog_Model_Product_Review extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Catalog_Model_Resource_Product_Review";
        $this->_collectionClassName = "Catalog_Model_Resource_Product_Review_Collections";
    }
}

?>