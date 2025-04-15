<?php

class Core_Controller_Admin_Action extends Core_Controller_Front_Action
{
    protected $_allowedActions = [];
    protected $_roleAllowedActions = [];
    public function __construct()
    {
        $this->_init();
    }

    protected function _init()
    {
        $islogin = $this->getSession()->get('adminlogin');
        if (!in_array($this->getRequest()->getActionName(), $this->_allowedActions)) {
            if ($islogin === $this->getSession()->get('id') && !empty($islogin)) {
                // print("in login match");
                // die;
                $admin = Mage::getSingleTon('admin/user')
                    ->load($this->getSession()->get('id'));
                
                // $role = Mage::getSingleTon('admin/role')
                //     ->load($admin->getRole());
                $this->getSession()->set('role_id', $admin->getRole());
                // $this->_roleAllowedActions = json_decode($role->getPermissions(), true);
            } else {
                $this->redirect("admin/account/login");
            }
        }
    }   

    public function getLayout() {
        return Mage::getBlockSingleTon("core/admin_layout");
    }
}
