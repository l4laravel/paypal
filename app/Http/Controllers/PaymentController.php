<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaymentController extends Controller
{
    private $apiContext;
    private $secret;
    private $clientId;

    public function __construct()
    {
        if (config('paypal.settings.mode') == 'live'){
            $this->clientId = config('paypal.live.client_id');
            $this->secret = config('paypal.live.secret');

        }else{

            $this->clientId = config('paypal.settings.client_id');
            $this->secret = config('paypal.settings.secret');
        }
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->clientId, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));

    }


    public function payWithPaypal(Request $request)
    {



        $price = $request->price;
        $name = $request->name;


        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item = new Item();
        $item->setName('Granola bars')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setDescription('Buying something from my site')
        ->setPrice(2);


        // itemList

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(2);


        // Transaction

        $transation = new Transaction();
        $transation->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Buying something from my site');



        // redirect urls

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('http://127.0.0.1:8000/status')
                ->setCancelUrl('http://127.0.0.1:8000/canceled');

        // Payment
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transation));
        
  try{
            $payment->create($this->apiContext);
        }catch (\PayPal\Exception\PPConnectionException $ex){
      echo '<pre>';print_r(json_decode($ex->getData()));exit;
        }


        $paymentLink = $payment->getApprovalLink();

        return redirect($paymentLink);
    }

    public function status()
    {
        return 'status';
    }

    public function conceled()
    {
        return 'Payment canceled. No Worries';
    }


}
