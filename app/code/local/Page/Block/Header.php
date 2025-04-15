<?php

class Page_Block_Header extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('page/header.phtml');
    }

    public function getCategories() {
        $category = Mage::getModel("catalog/category")
                    ->getCollection()
                    ->addFieldToFilter('parent_id',["="=>"1"]);
        return $category->getData();
    }

    public function getTotalProductCount() {
        return count(Mage::getModel("checkout/session")
            ->getCart()
            ->getItemCollection()
            ->getData());
    }
}
