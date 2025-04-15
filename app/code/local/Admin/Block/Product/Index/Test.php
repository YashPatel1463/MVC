<?php

class Admin_Block_Product_Index_Test extends Core_Block_Template {
    public function __construct() {
        $this->setTemplate('admin/product/index/test.phtml');
    }
    
    public function getHtmlField($field, $data) {
        $field = ucfirst(strtolower($field));
        $className = sprintf("Admin_Block_Html_Elements_%s",$field);

        $element = new $className($data);
        return $element->render();
    }
}

?>