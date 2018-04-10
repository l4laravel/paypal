<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paypal\Rest\ApiContext;
use Paypal\Auth\OAuthTokenCredential;

class PaymentController extends Controller
{
    private $apiContext;
    private $secret;
    private $clientId;

    public function __construct()
    {
        if (config('paypal.settings.mode') == 'live'){
            $this->clientId = config('paypal.live.client_id');
            $this->secret = config('paypal.live.client_id');
        }else{
            $this->clientId = config('paypal.sandox.client_id');
            $this->secret = config('paypal.sandbox.secret');
        }
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->clientId, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));

    }


    public function payWithPaypal(Request $request)
    {
        $price = $request->price;
        $name = $request->name;
        
    }

}
