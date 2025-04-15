<?php

class Admin_Block_Dashboard_Index extends Core_Block_Template {
    public function __construct() {
        $this->setTemplate('admin/dashboard.phtml');
    }

    public function getPermission($askpermission) {
        $role = Mage::getModel('admin/user_session')
            ->getRole();

        // Mage::log($role);
        // die;
        $permissions = json_decode($role->getPermissions(), true);
        $permission = explode('/', $askpermission);
        if(isset($permission[0]) && in_array($permission[1], $permissions[$permission[0]])) {
            return true;
        } else {
            return false;
        }
    }
}

?>