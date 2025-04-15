<?php 

class Ems_Model_Event extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Ems_Model_Resource_Event";
        $this->_collectionClassName = "Ems_Model_Resource_Event_Collections";
    }

    public function isLogin() {
        $sesion = Mage::getSingleTon('core/session');
        if($sesion->get('customer_id')) {
            return true;
        } else {
            return false;
        }
    }
}

?>