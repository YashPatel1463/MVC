<?php 

class Ticket_Model_Comment extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Ticket_Model_Resource_Comment";
        $this->_collectionClassName = "Ticket_Model_Resource_Comment_Collections";
    }
}

?>