<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingInfoController extends Controller
{
    public function billingInfo()
    {
        return view('client.billing_info.billing_info');
    }
}
