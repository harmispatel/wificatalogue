<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::get();
        return view('client.menu.menu',$data);
    }
}
