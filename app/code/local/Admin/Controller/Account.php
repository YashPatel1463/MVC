<?php

class Admin_Controller_Account extends Core_Controller_Admin_Action {
    protected $_allowedActions = ["login", "loginPost"];

    public function loginAction() {
        $layout =  Mage::getBlock('core/layout');
        $login = $layout->createBlock('admin/account_login');
        $layout->getChild('content')->addChild('login', $login);
        $layout->toHtml();
        // $session = Mage::getModel("core/session");
        // $id = $session->getId();
        // var_dump($id);

        // // $session->set("login", "1");
        // // echo $session->get("login");
        // // echo $session->remove("login");
        
        // echo "<pre>";
        // print_r($_SESSION);
        // echo "</pre>";
        // echo "hello";
        //login form
    }

    public function loginPostAction() {
        $session = Mage::getSingleTon("core/session");

        $params = $this->getRequest()->getParam("admin");
        
        // echo $params["username"];
        $admin = Mage::getModel("admin/user")
                        ->load($params["username"], "username");
        
        // echo "<pre>";
        // print_r($params);
        // print_r($admin);
        // echo "</pre>";
        // die();
        // $params = ["username" => "admin", "password" => "123"];
        
        if($params["username"] == $admin->getUsername() && $params["password"] == $admin->getPasswordHash()) {
            // echo "123";
            // die();
            //manage from table
            $session->set("login", $admin->getAdminId());
            $session->set("id", $admin->getAdminId());
            // print("session set");
            $this->redirect("admin/product_index/list");
        }
        else {
            // echo "selse";
            // die();
            $session->remove("login");
            $session->remove("id");
            $this->redirect("admin/account/login");
        }
        // echo "<pre>";
        // print_r($params);
        // echo "</pre>";
    }
}

//user name uniq
//load() data
//match password
// "login", 1 placce id
// admin start with extend core admin action

?>