<?php

class Admin_Controller_Dashboard extends Core_Controller_Admin_Action
{
    protected $_allowedActions = [];

    public function indexAction()
    {
        $layout =  $this->getLayout();
        $index = $layout->createBlock('admin/dashboard_index');
        $layout->getChild('content')->addChild('index', $index);
        $layout->getChild('head')->addCss('admin/dashboard/index.css');
        
        $layout->toHtml();
    }

    public function logoutAction()
    {
        $session = Mage::getSingleTon("core/session");
        $session->remove("login");
        $session->remove("id");
        $this->getMessage()
            ->addSuccess('Logout Successfully.');
        $this->redirect("admin/account/login");
    }
}
