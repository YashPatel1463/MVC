<?php 

class Ems_Block_Event_New extends Core_Block_Template {
    public function __construct() {
        $this->setTemplate('ems/event/new.phtml');
    }

    public function getEvents() {
        return Mage::getModel('ems/event')
            ->load($this->getRequest()->getQuery('edit_id'));
    }
}

?>