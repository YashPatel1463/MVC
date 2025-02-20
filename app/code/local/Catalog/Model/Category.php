<?php

class Catalog_Model_Category extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Catalog_Model_Resource_Category";
        $this->_collectionClassName = "Catalog_Model_Resource_Category_Collections";
    }

}

?>