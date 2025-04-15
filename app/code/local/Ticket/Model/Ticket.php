<?php 

class Ticket_Model_Ticket extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Ticket_Model_Resource_Ticket";
        $this->_collectionClassName = "Ticket_Model_Resource_Ticket_Collections";
    }
}

?>