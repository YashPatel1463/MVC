<?php

class Ems_Block_Event_View extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('ems/event/view.phtml');
    }

    public function getEvents()
    {
        return Mage::getModel('ems/registrations')
            ->getCollection()
            ->addFieldToFilter('event_id', ['=' => $this->getRequest()->getQuery('event_id')])
            ->getData();
    }

    public function getTitle()
    {
        return Mage::getModel('ems/event')
            ->getCollection()
            ->select(['title'])
            ->addFieldToFilter('event_id', ['=' => $this->getRequest()->getQuery('event_id')])
            ->getFirstItem()
            ->getTitle();
    }

    public function getTotalUser()
    {
        return  Mage::getModel('ems/registrations')
            ->getCollection()
            ->select(['total' => 'count(*)'])
            ->addFieldToFilter('event_id', ['=' => $this->getRequest()->getQuery('event_id')])
            ->getFirstItem()
			//->prepareQuery();
            ->getTotal();
    }

    public function getPendingUser()
    {
        return  Mage::getModel('ems/registrations')
            ->getCollection()
            ->select(['total' => 'count(*)'])
            ->addFieldToFilter('event_id', ['=' => $this->getRequest()->getQuery('event_id')])
            ->addFieldToFilter('status', ['=' => 'pending'])
            ->getFirstItem()
            ->getTotal();
    }

    public function getApproveUser()
    {
        return  Mage::getModel('ems/registrations')
            ->getCollection()
            ->select(['total' => 'count(*)'])
            ->addFieldToFilter('event_id', ['=' => $this->getRequest()->getQuery('event_id')])
            ->addFieldToFilter('status', ['=' => 'approve'])
            ->getFirstItem()
            ->getTotal();
    }

    public function getRejectUser()
    {
        return  Mage::getModel('ems/registrations')
            ->getCollection()
            ->select(['total' => 'count(*)'])
            ->addFieldToFilter('event_id', ['=' => $this->getRequest()->getQuery('event_id')])
            ->addFieldToFilter('status', ['=' => 'reject'])
            ->getFirstItem()
            ->getTotal();
    }
}
