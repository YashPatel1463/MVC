<?php

use PayPal\Rest\ApiContext;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

class Paypal_Controller_Transaction extends Core_Controller_Customer_Action
{
    public function startAction()
    {
        $paypal = new PayPal_Init();
        $paypal = $paypal->getApiContext();

        $payer = new PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new PayPal\Api\Amount();

        $cart = Mage::getSingleTon("checkout/session")
            ->getCart();

        $amount->setTotal($cart->getTotalAmount())->setCurrency('USD');

        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)->setDescription('Payment for Order #1234');

        $redirectUrls = new PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(Mage::getBaseUrl() . 'Paypal/Transaction/success')
            ->setCancelUrl(Mage::getBaseUrl() . 'Paypal/Transaction/cancel');

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

    public function successAction()
    {
        if (!isset($_GET['paymentId'], $_GET['PayerID'])) {
            die("Payment failed or canceled.");
        }

        $paypal = new PayPal_Init();
        $paypal = $paypal->getApiContext();

        $paymentId = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];

        try {
            // Retrieve the payment by ID
            $payment = Payment::get($paymentId, $paypal);

            // Create an execution object
            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            // Execute the payment
            $result = $payment->execute($execution, $paypal);

            // Check if the payment was successful
            if ($result->getState() == 'approved') {
                echo "Payment successful! Transaction ID: " . $result->getId();
                $this->redirect("checkout/order/convert?transaction_id={$result->getId()}");
            } else {
                echo "Payment not approved.";
            }
        } catch (Exception $ex) {
            echo "Payment execution error: " . $ex->getMessage();
        }
    }

    public function cancelAction() {}
}
