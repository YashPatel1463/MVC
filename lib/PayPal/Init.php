<?php

use PayPal\Auth\OAuthTokenCredential; // Import the OAuthTokenCredential class

class PayPal_Init
{
    protected $_includeFile = null;
    public function __construct()
    {
        // echo "123";
        // $obj = new PayPal_Autoload();
    }

    public function getApiContext()
    {
        $paypal = new PayPal\Rest\ApiContext(
            new PayPal\Auth\OAuthTokenCredential(
                '',
                ''
            )
        );

        $paypal->setConfig([
            'mode' => 'sandbox', // Change to 'live' in production 
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ]);

        return $paypal;
    }
}
