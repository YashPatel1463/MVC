<?php

class Core_Controller_Admin_Action extends Core_Controller_Front_Action
{
    protected $_allowedActions = [];
    public function __construct()
    {
        $this->_init();
    }

    protected function _init()
    {
        $islogin = $this->getSession()->get('login');
        // $id=$this->getSession()->get('id');
        // print("the login is".$islogin);
       
        // print("the id is : ".$id);
        // echo $this->getSession()->get('id');
        // die();
        if (!in_array($this->getRequest()->getActionName(), $this->_allowedActions)) {
            if ($islogin === $this->getSession()->get('id') && !empty($islogin)) {
                // print("in login match");
            } else {
                $this->redirect("admin/account/login");
            }
        }
    }
}
