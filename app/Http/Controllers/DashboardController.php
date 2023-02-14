<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Display Admin Dashboard.
    public function index()
    {
        $clients['total'] = User::where('user_type',2)->count();
        $clients['active'] = User::where('user_type',2)->where('status',1)->count();
        $clients['nonactive'] = User::where('user_type',2)->where('status',0)->count();

        $data['client'] = $clients;
        $data['recent_clients'] = User::with(['hasOneShop','hasOneSubscription'])->where('user_type',2)->orderBy('created_at','asc')->limit(10)->get();

        return view('admin.dashboard.dashboard',$data);
    }
}
