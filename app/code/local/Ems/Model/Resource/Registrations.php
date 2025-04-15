<?php 

class Ems_Model_Resource_Registrations extends Core_Model_Resource_Abstract {
    public function _construct() {
        $this->init('registrations', 'registration_id');
    }
}

?>