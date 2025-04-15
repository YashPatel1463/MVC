<?php

class Admin_Block_Category_Index_List extends Core_Block_Template
{
    protected $_collection;
    public function __construct()
    {
        $this->setTemplate('admin/category/index/list.phtml');
        $this->init();
    }

    public function init()
    {
        $toolbar = $this->getLayout()->createBlock("admin/grid_toolbar")
            ->setTemplate("admin/grid/toolbar.phtml");

        $this->addChild("toolbar", $toolbar);

        $this->_collection = Mage::getModel('catalog/category')
            ->getCollection();

        // $this->_collection = $toolbar->prepareToolbar();
        $toolbar->prepareToolbar();
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    public function getCategoriesData()
    {
        return $this->getCollection()->getData();
    }
}
