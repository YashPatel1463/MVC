<?php

use PayPal\Rest\ApiContext;


class Catalog_Controller_Product extends Core_Controller_Customer_Action
{
    protected $_allowedActions = ['addReview'];

    public function viewAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('catalog/product_view');
        $layout->getChild('content')->addChild('view', $view);
        $layout->getChild('head')->addCss('catalog/view.css')
            ->addJs('catalog/view.js');
        $layout->toHtml();
    }

    public function listAction()
    {
        // echo '123';
        $layout =  Mage::getBlock('core/layout');

        $list = $layout->createBlock('catalog/product_list');
        $layout->getChild('content')->addChild('list', $list);

        $layout->getChild('head')->addCss('catalog/list.css')
            ->addCss("catalog/product/list.css")
            ->addJs("catalog/list.js");

        if ($this->getRequest()->isAjax()) {
            $layout->removeChild('header')
                ->removeChild('footer')
                ->removeChild('head');
            $layout->getChild('content')->getChild('list')
                ->removeChild('filter');
        }

        $layout->toHtml();
    }

    public function addReviewAction() {
        $review = $this->getRequest()->getParam('catalog_product_review');
        $customer_id = $this->getSession()->get('customer_id');
        Mage::getModel('catalog/product_review')
            ->setData($review)
            ->setCustomerId($customer_id)
            ->save();
    }

    

    public function TestAction()
    {
        // getcwd();
        $paypal = new PayPal_Init();
        $paypal = $paypal->getApiContext();

        // echo "<pre>";
        // print_r($paypal);
        // echo "</pre>";

        $payer = new PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new PayPal\Api\Amount();
        $amount->setTotal('10.00')->setCurrency('USD');

        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)->setDescription('Payment for Order #1234');

        $redirectUrls = new PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl("http://localhost/payment/paypal_success.php")
            ->setCancelUrl("http://localhost/payment/paypal_cancel.php");

        $payment = new PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($paypal);
            header("Location: " . $payment->getApprovalLink());
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    
}
