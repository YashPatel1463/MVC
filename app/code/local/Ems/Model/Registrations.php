<?php 

class Ems_Model_Registrations extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Ems_Model_Resource_Registrations";
        $this->_collectionClassName = "Ems_Model_Resource_Registrations_Collections";
    }
}

?>