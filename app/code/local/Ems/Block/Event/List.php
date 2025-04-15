<?php

class Ems_Block_Event_List extends Core_Block_Template
{
    protected $_collection;
    public function __construct()
    {
        $this->setTemplate('ems/event/list.phtml');
		//echo "12";
        $this->init();
    }

    public function init()
    {
		//echo "12";
        $toolbar = $this->getLayout()->createBlock("ems/grid_toolbar")
            ->setTemplate("ems/grid/toolbar.phtml");

        $this->addChild("toolbar", $toolbar);
		
        $this->_collection =  Mage::getModel('ems/event')
            ->getCollection()
            ->select(['*', 'total' => 'COUNT(r.event_id)'])
            ->leftJoin(["r" => "registrations"], "r.event_id = main_table.event_id", [])
            ->groupBy('main_table.event_id');
        
        $toolbar->prepareToolbar();
    }

    public function getCollection( )
    {
		//echo "12";
        return $this->_collection;
    }

    public function getEvents()
    {
		//echo "12";
        return $this->getCollection()->getData();
    }
}
