<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingInfoController extends Controller
{
    public function billingInfo()
    {
        $data['expire_date'] =  (isset(Auth::user()->hasOneSubscription['end_date'])) ? \Carbon\Carbon::now()->diffInMonths(Auth::user()->hasOneSubscription['end_date'], false) : '';
        $data['user'] = User::where('id',Auth::user()->id)->first();
        $data['countries'] = Country::get();
        return view('client.billing_info.billing_info',$data);
    }

    public function updateBillingInfo(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
            'country' => 'required',
        ]);

        $user = User::find($request->user_id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->zipcode = $request->zipcode;
        $user->update();

        return redirect()->route('billing.info')->with('success', "Billing Information has Been Updated SuccessFully...");

    }
}
