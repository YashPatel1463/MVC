<?php 

class Ems_Model_Resource_Event extends Core_Model_Resource_Abstract {
    public function _construct() {
        $this->init('event', 'event_id');
    }
}

?>