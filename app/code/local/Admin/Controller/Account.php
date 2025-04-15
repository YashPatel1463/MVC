<?php

class Admin_Controller_Account extends Core_Controller_Admin_Action
{
    protected $_allowedActions = ["login", "loginPost"];

    public function loginAction()
    {
        $layout =  $this->getLayout();
        $login = $layout->createBlock('admin/account_login');
        $layout->getChild('content')->addChild('login', $login);
        $layout->toHtml();
    }

    public function loginPostAction()
    {
        $session = Mage::getSingleTon("core/session");

        $params = $this->getRequest()->getParam("admin");
        // Mage::log($params);
        // die;
        // echo $params["username"];
        $admin = Mage::getModel("admin/user")
            ->load($params["username"], "username");

        // echo "<pre>";
        // print_r($params);
        // print_r($admin);
        // echo "</pre>";
        // die();
        // $params = ["username" => "admin", "password" => "123"];

        if ($params["username"] == $admin->getUsername() && $params["password"] == $admin->getPasswordHash()) {
            // echo "123";
            // die();
            //manage from table
            $session->set("adminlogin", $admin->getAdminId());
            $session->set("id", $admin->getAdminId());
            $this->getMessage()
                ->addSuccess('Login Successfully.');
            // print("session set");
            $this->redirect("admin/dashboard/index");
        } else {
            // echo "selse";
            // die();
            $session->remove("adminlogin");
            $session->remove("id");
            $this->getMessage()
                ->addError('Invalid Credentials.');
            $this->redirect("admin/account/login");
        }
        // echo "<pre>";
        // print_r($params);
        // echo "</pre>";
    }
}
