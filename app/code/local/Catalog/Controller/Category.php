<?php

class Catalog_Controller_Category {
    public function listAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/category_list');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }
}

?>