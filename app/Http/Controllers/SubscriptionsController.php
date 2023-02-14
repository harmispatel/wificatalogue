<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\Subscriptions;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $data['subscriptions'] = Subscriptions::get();
        return view('admin.subscription.subscription',$data);
    }


    public function insert()
    {
        return view('admin.subscription.new_subscription');
    }


    public function store(SubscriptionRequest $request)
    {
        $title = $request->title;
        $price = $request->price;
        $duration = $request->duration;
        $status = $request->status;
        $description = $request->description;

        // Insert New Subscription
        $subscription = new Subscriptions();
        $subscription->name = $title;
        $subscription->price = $price;
        $subscription->duration = $duration;
        $subscription->status = $status;
        $subscription->description = $description;
        $subscription->save();

        return redirect()->route('subscriptions')->with('success','Subscription has been Inserted SuccessFully....');

    }


    public function destroy($id)
    {
        // Delete Subscription
        Subscriptions::where('id',$id)->delete();

        return redirect()->route('subscriptions')->with('success','Subscription has been Removed SuccessFully..');
    }



    public function edit($id)
    {
        try 
        {
            $data['subscription'] = Subscriptions::where('id',$id)->first();

            if($data['subscription'])
            {
                return view('admin.subscription.edit_subscription',$data);
            }
            return redirect()->route('subscriptions')->with('error', 'Something went wrong!');
        } 
        catch (\Throwable $th) 
        {
            return redirect()->route('subscriptions')->with('error', 'Something went wrong!');
        }
    }


    public function update(SubscriptionRequest $request)
    {
        $id = $request->subscription_id;
        $title = $request->title;
        $price = $request->price;
        $duration = $request->duration;
        $status = $request->status;
        $description = $request->description;

        $subscription = Subscriptions::find($id);
        $subscription->name = $title;
        $subscription->price = $price;
        $subscription->duration = $duration;
        $subscription->status = $status;
        $subscription->description = $description;
        $subscription->update();

        return redirect()->route('subscriptions')->with('success','Subscription has been Updated SuccessFully....');
        
    }


}
