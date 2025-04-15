<?php

class Ems_Controller_User extends Core_Controller_Customer_Action
{
    protected $_allowedActions = ["login", "loginPost", "dashboard"];

    public function loginAction()
    {
        $layout =  $this->getLayout();
        $login = $layout->createBlock('customer/account_login');
        $layout->getChild('content')->addChild('login', $login);
        $layout->getChild('head')->addCss('customer/account/login.css');
        $layout->toHtml();
    }

    public function loginPostAction()
    {
        $session = $this->getSession();

        $params = $this->getRequest()->getParam("customer");

        $customer = Mage::getModel("customer/account")
            ->load($params["email"], "email");

        if ($params["email"] == $customer->getEmail() && $params["password"] == $customer->getPassword()) {
            $session->set("login", $customer->getCustomerId());
            $session->set("customer_id", $customer->getCustomerId());
            $this->getMessage()
                ->addSuccess('Login Successfully.');
            $this->redirect("ems/user/dashboard");
        } else {
            $this->getMessage()
                ->addError('Invalid Credentials.');
            $session->remove("login");
            $session->remove("customer_id");
            $this->redirect("customer/account/login");
        }
    }

    public function dashboardAction()
    {
        $layout =  $this->getLayout();
        $dashboard = $layout->createBlock('ems/user_dashboard');
        $layout->getChild('content')->addChild('dashboard', $dashboard);

        $this->getLayout()
            ->getChild('head')
            ->addCss('ems/event/list.css');
        $layout->toHtml();
    }

    public function registerAction()
    {
        if ($this->getSession()->get('customer_id')) {
            $event_id = $this->getRequest()->getQuery('event_id');
            $user_id = $this->getSession()->get('customer_id');

            Mage::getModel('ems/registrations')
                ->setUserId($user_id)
                ->setEventId($event_id)
                ->setStatus('pending')
                ->setRegisteredAt(Date('Y-m-d H:i:s'))
                ->save();

            $this->getMessage()
                ->addSuccess('Registration Successfully for Event.');
            $this->redirect('ems/user/dashboard');
        } else {
            $this->getMessage()
                ->addError('Plese Login to Register in Event.');
            $this->getSession()->remove("login");
            $this->getSession()->remove("customer_id");
            $this->redirect("customer/account/login");
        }
    }
}
