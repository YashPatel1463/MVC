<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Customer_Controller_Account extends Core_Controller_Customer_Action
{
    protected $_allowedActions = ["login", "loginPost", "registration", "registrationPost", "forgotpassword", "sendOtp", "verifyOtp", "change"];
    public function registrationAction()
    {
        // echo get_class() . "<br>" . __FUNCTION__;
        $layout =  $this->getLayout();
        $new = $layout->createBlock('customer/account_registration');
        $layout->getChild('content')->addChild('new', $new);
        $layout->getChild('head')->addCss('customer/account/registration.css');
        $layout->toHtml();
    }

    public function registrationPostAction()
    {
        $customer_data = $this->getRequest()->getParam('customer');
        // Mage::log($customer_data);
        // die;
        $customer = Mage::getModel("customer/account")
            ->setData($customer_data)
            ->save();

        $session = Mage::getSingleTon("core/session");
        $session->set("login", $customer->getCustomerId());
        $session->set("customer_id", $customer->getCustomerId());
        $this->getMessage()
            ->addSuccess('Registration Successfully.');
        $this->redirect("");
    }

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
        $session = Mage::getSingleTon("core/session");

        $params = $this->getRequest()->getParam("customer");

        $customer = Mage::getModel("customer/account")
            ->load($params["email"], "email");

        if ($params["email"] == $customer->getEmail() && $params["password"] == $customer->getPassword()) {
            $session->set("login", $customer->getCustomerId());
            $session->set("customer_id", $customer->getCustomerId());
            // echo "<pre>";
            // print_r($_SESSION);
            // echo "</pre>";   
            // die;
            $this->getMessage()
                ->addSuccess('Login Successfully.');
            // ->addSuccess('Login done.');
            // $this->redirect("");
            $this->redirect('catalog/product/list');
        } else {
            $this->getMessage()
                ->addError('Invalid Credentials.');
            $session->remove("login");
            $session->remove("customer_id");
            $this->redirect("customer/account/login");
        }
    }

    public function logoutAction()
    {
        $session = Mage::getSingleTon("core/session");

        $session->remove("login");
        $session->remove("customer_id");
        $this->getMessage()
            ->addSuccess('Logout Successfully.');
        $this->redirect("customer/account/login");
    }

    public function dashboardAction()
    {
        $customer = Mage::getModel("customer/account")
            ->load($this->getSession()->get('customer_id'));

        $layout =  $this->getLayout();
        $dashboard = $layout->createBlock('customer/account_dashboard')
            ->setCustomerData($customer);

        $info = $layout->createBlock('customer/account_dashboard_info');
        $dashboard->addChild('info', $info);

        // Mage::log($info);
        $address = $layout->createBlock('customer/account_dashboard_address');
        $dashboard->addChild('address', $address);

        $orders = $layout->createBlock('customer/account_dashboard_orders');
        $dashboard->addChild('orders', $orders);

        $layout->getChild('content')->addChild('dashboard', $dashboard);

        $layout->getChild('head')->addCss('customer/account/dashboard.css')
            ->addJs('customer/account/address/defaultAddress.js');

        if ($this->getRequest()->isAjax()) {
            $layout->removeChild('header')
                ->removeChild('footer')
                ->removeChild('head');
            $layout->getChild('content')->getChild('dashboard')
                ->removeChild('info')
                ->removeChild('orders');
        }

        $layout->toHtml();
    }

    public function changePasswordAction()
    {
        $layout = $this->getLayout();
        $change = $layout->createBlock("customer/account_changePassword");
        $layout->getChild('content')->addChild('change', $change);
        $layout->getChild('head')->addJs('customer/account/changePassword.js');
        $layout->toHtml();
    }

    public function savePasswordAction()
    {
        header('Content-Type: application/json');
        $passwords = $this->getRequest()->getParam('password');

        $customer = Mage::getModel("customer/account")
            ->load($this->getSession()->get('customer_id'));

        // Mage::log($customer);
        if ($passwords['current_password'] !== $customer->getPassword()) {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
            return;
        }

        $customer->setPassword($passwords['new_password'])
            ->save();

        $this->getMessage()
            ->addSuccess('Password Changed Successfully.');
        echo json_encode(['success' => true]);
    }

    public function forgotpasswordAction()
    {
        $layout = $this->getLayout();
        $forgot = $layout->createBlock("customer/account_forgotpassword");
        $layout->getChild('content')->addChild('forgot', $forgot);
        $layout->getChild('head')->addCss('customer/account/forgot.css')
            ->AddJs('customer/account/forgot.js');
        $layout->toHtml();
    }

    public function sendOtpAction()
    {
        $customer = Mage::getModel("customer/account")
            ->load($this->getRequest()->getParam('email'), "email");

        if ($customer->getData())
            // Generate OTP
            $otp = rand(1000, 9999);

        // Store OTP in session
        Mage::getSingleton('core/session')->set("OTP", $otp);
        Mage::getSingleton('core/session')->set('otp_email', $this->getRequest()->getParam('email'));

        // Send email
        $mail = new PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'patelyash140603@gmail.com';
            $mail->Password = 'bkzu kelr hlyw ykbj';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Sender and recipient
            $mail->setFrom('patelyash140603@gmail.com', 'Yash Patel');
            $mail->addAddress("patelyash140603@gmail.com");

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "<p>Hello,</p><p>Your OTP code is: <strong>{$otp}</strong></p><p>This code will expire in 5 minutes.</p>";

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'OTP sent successfully!']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
        }
    }

    public function verifyOtpAction()
    {
        $params = $this->getRequest()->getParams();
        $session = $this->getSession();
        $otp = trim($params['otp']);

        if ($session->get('OTP') == $otp) {
            echo json_encode(["success" => true, "message" => "OTP Verified!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid OTP!"]);
        }
    }

    public function changeAction()
    {
        // header('Content-Type: application/json');
        $params = $this->getRequest()->getParams();
        $customer_id = Mage::getModel('customer/account')->load($this->getSession()->get('otp_email'), 'email');
        $id = $customer_id->getCustomerId();
        $session = $this->getSession();

        try {
            $customer = Mage::getModel('customer/account')
                ->setPassword($params['password'])
                ->setCustomerId($id)
                ->save();

            $this->getMessage()
                ->addSuccess('Password Changed Successfully.');
            echo json_encode(["success" => true, "message" => "Password changed successfully!"]);
            exit;
        } catch (Exception $e) {
            $this->getMessage()
                ->addError("Password can't changed.");
            echo json_encode(["success" => false, "message" => "Error updating password: " . $e->getMessage()]);
        }
    }
}
