<?php

class Admin_Block_Product_Index_List extends Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {   
        $this->setTemplate('admin/product/index/list.phtml');
        $this->init();
    }

    public function init()
    {
        $toolbar = $this->getLayout()->createBlock("admin/grid_toolbar")
                        ->setTemplate("admin/grid/toolbar.phtml");

        $this->addChild("toolbar",$toolbar);

       $this->_collection = Mage::getModel("catalog/product")
       ->getCollection()
       ->addAttributeToSelect(["color", "weight","material", "warranty", "manufacturer", "countryoforigin"]);
       
        $toolbar->prepareToolbar();
    }

    public function getCollection() {
        return $this->_collection;
    }

    public function getProductsData()
    {
        return $this->getCollection()->getData();
    }   

    public function getAttributes() {
        $attribute = Mage::getModel('catalog/attribute')
                            ->getCollection();
        return $attribute->getData();
    }

}
