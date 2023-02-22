<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function logo()
    {
        return view('client.design.logo');
    }

    public function theme()
    {
        return view('client.design.theme');
    }

    public function cover()
    {
        return view('client.design.cover');
    }

    public function banner()
    {
        return view('client.design.banner');
    }

    public function themePrview()
    {
        return view('client.design.theme_preview');
    }

    public function generalInfo()
    {
        return view('client.design.general_info');
    }
}
