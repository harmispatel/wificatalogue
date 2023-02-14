<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Display Admin Dashboard.
    public function index()
    {
        return view('admin.dashboard.dashboard');
    }
}
