<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopQrController extends Controller
{
    public function index()
    {
        return view('client.qrcode.view_qrcode');
    }
}
