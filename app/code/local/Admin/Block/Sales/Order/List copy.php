<?php

class Admin_Block_Sales_Order_List extends Core_Block_Template
{
    protected $_collection;
    public function __construct()
    {
        $this->setTemplate("admin/sales/order/list.phtml");
        $this->init();
    }
    
    public function init()
    {
        $toolbar = $this->getLayout()->createBlock("admin/grid_toolbar")
            ->setTemplate("admin/grid/toolbar.phtml");

        $this->addChild("toolbar", $toolbar);

        $this->_collection =  Mage::getModel("sales/order")
            ->getCollection();

        // $this->_collection = $toolbar->prepareToolbar();
        $toolbar->prepareToolbar();
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    public function getOrderData()
    {
        return $this->getCollection()->getData();
    }
}
