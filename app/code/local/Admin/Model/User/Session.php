<?php

class Admin_Model_User_Session extends Core_Model_Session {
    public function getRole() {
        return Mage::getModel('admin/role')
            ->load($this->get('role_id'));
    }
}

?>