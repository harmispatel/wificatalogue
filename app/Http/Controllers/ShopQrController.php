<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopQrController extends Controller
{
    public function index()
    {
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
        $data['shop_details'] = Shop::where('id',$shop_id)->first();
        return view('client.qrcode.view_qrcode',$data);
    }
}
