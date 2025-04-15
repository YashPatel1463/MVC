<?php
class Core_Controller_Customer_Action extends Core_Controller_Front_Action
{
    protected $_allowedActions = [];
    public function __construct()
    {
        $this->_init();
    }

    protected function _init()
    {
        $islogin = $this->getSession()->get('login');
        if (!in_array($this->getRequest()->getActionName(), $this->_allowedActions)) {
            if ($islogin === $this->getSession()->get('customer_id') && !empty($islogin)) {
            } else {
                $this->redirect('customer/account/login');
            }
        }
    }
}