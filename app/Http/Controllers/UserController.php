<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Shop;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\UserShop;
use App\Models\UsersSubscriptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data['clients'] = User::where('user_type',2)->get();
        return view('admin.clients.clients',$data);
    }

    public function insert()
    {
        $data['subscriptions'] = Subscriptions::where('status',1)->get();
        return view('admin.clients.new_clients',$data);
    }

    public function store(ClientRequest $request)
    {
        $subscription_id = $request->subscription;

        $subscription = Subscriptions::where('id',$subscription_id)->first();
        $subscription_duration = isset($subscription->duration) ? $subscription->duration : '';

        $date = Carbon::now();
        $current_date = $date->toDateTimeString();
        $end_date = $date->addMonths($subscription_duration)->toDateTimeString();
        $duration = $subscription_duration.' Months.';

        $username = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $status = $request->status;
        $shop_name = $request->shop_name;
        $shop_description = $request->shop_description;

        // Insert New Client
        $client = new User();
        $client->name = $username;
        $client->email = $email;
        $client->password = $password;
        $client->status = $status;
        $client->user_type = 2;
        $client->save();

        if($client->id)
        {
            // Insert Client Shop
            $shop = new Shop();
            $shop->name = $shop_name;
            $shop->description = $shop_description;

            if($request->hasFile('shop_logo'))
            {
                $imgname = time().".". $request->file('shop_logo')->getClientOriginalExtension();
                $request->file('shop_logo')->move(public_path('admin_uploads/shop/'), $imgname);
                $imageurl = asset('/').'public/admin_uploads/shop/'.$imgname;
                $shop->logo = $imageurl;
            }
            $shop->save();


            // Insert User Subscriptions
            if($subscription_id)
            {
                $user_subscription = new UsersSubscriptions();
                $user_subscription->user_id = $client->id;
                $user_subscription->subscription_id = $subscription_id;
                $user_subscription->duration = $duration;
                $user_subscription->start_date = $current_date;
                $user_subscription->end_date = $end_date;
                $user_subscription->save();
            }

        }

        if($client->id && $shop->id)
        {
            $userShop = new UserShop();
            $userShop->user_id = $client->id;
            $userShop->shop_id = $shop->id;
            $userShop->save();
        }

        return redirect()->route('clients')->with('success','Client has been Inserted SuccessFully....');

    }


    public function update(ClientRequest $request)
    {
        $subscription_id = $request->subscription;

        $subscription = Subscriptions::where('id',$subscription_id)->first();
        $subscription_duration = isset($subscription->duration) ? $subscription->duration : '';

        $date = Carbon::now();
        $current_date = $date->toDateTimeString();
        $end_date = $date->addMonths($subscription_duration)->toDateTimeString();
        $duration = $subscription_duration.' Months.';

        $username = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $status = $request->status;
        $shop_id = $request->shop_id;
        $shop_name = $request->shop_name;
        $shop_description = $request->shop_description;

        // Update New Client
        $client = User::find($request->client_id);
        $client->name = $username;
        $client->email = $email;

        if(!empty($password))
        {
            $client->password = $password;
        }

        $client->status = $status;
        $client->update();


        // Update User Subscriptions
        if(!empty($subscription_id ) && !empty($request->user_sub_id))
        {
            $user_subscription = UsersSubscriptions::find($request->user_sub_id);
            $user_subscription->subscription_id = $subscription_id;
            $user_subscription->duration = $duration;
            $user_subscription->start_date = $current_date;
            $user_subscription->end_date = $end_date;
            $user_subscription->update();
        }


        // Update Client Shop
        $shop = Shop::find($shop_id);
        $shop->name = $shop_name;
        $shop->description = $shop_description;

        if($request->hasFile('shop_logo'))
        {

            $old_image = isset($shop->logo) ? $shop->logo : '';
            if(!empty($old_image))
            {
                if(file_exists($old_image))
                {
                    unlink($old_image);
                }
            }

            $imgname = time().".". $request->file('shop_logo')->getClientOriginalExtension();
            $request->file('shop_logo')->move(public_path('admin_uploads/shop/'), $imgname);
            $imageurl = asset('/').'public/admin_uploads/shop/'.$imgname;
            $shop->logo = $imageurl;
        }
        $shop->update();

        return redirect()->route('clients')->with('success','Client has been Updated SuccessFully....');
    }


    public function destroy($id)
    {
        // Get User Details
        $user = User::with(['hasOneShop'])->where('id',$id)->first();
        $shop_id = isset($user->hasOneShop->shop['id']) ? $user->hasOneShop->shop['id'] : '';

        if(!empty($shop_id))
        {
            $shop = Shop::where('id',$shop_id)->first();
            $shop_logo = isset($shop->logo) ? $shop->logo : '';

            if(!empty($shop_logo) && file_exists($shop_logo))
            {
                unlink($shop_logo);
            }

            Shop::where('id',$shop_id)->delete();
        }

        // Delete UserShop
        UserShop::where('user_id',$id)->delete();

        // Delete User
        User::where('id',$id)->delete();

        return redirect()->route('clients')->with('success','Client has been Removed SuccessFully..');
    }


    public function edit($id)
    {
       try
       {
            $data['client'] = User::with(['hasOneShop','hasOneSubscription'])->where('id',$id)->first();
            $data['subscriptions'] = Subscriptions::where('status',1)->get();

            if($data['client'])
            {
                return view('admin.clients.edit_clients',$data);
            }
            return redirect()->route('clients')->with('error', 'Something went wrong!');
       }
       catch (\Throwable $th)
       {
            return redirect()->route('clients')->with('error', 'Something went wrong!');
       }
    }


    public function editProfile($id)
    {
        $data['user'] = User::where('id',decrypt($id))->first();

        if(Auth::user()->user_type == 1)
        {
            return view('auth.admin-profile',$data);
        }
        else
        {
            dd(1);
        }
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'                  =>      'required',
            'email'                 =>      'required|email|unique:users,email,'.$request->user_id,
            'confirm_password'      =>      'same:password',
            'profile_picture'       =>      'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG'
        ]);

        $user  = User::find($request->user_id);

        if(Auth::user()->user_type == 1)
        {
            $user->name = $request->name;
            $user->email = $request->email;

            if(!empty($request->password))
            {
                $user->password = Hash::make($request->password);
            }

            if($request->hasFile('profile_picture'))
            {
                // Remove Old Image
                $old_image = isset($user->image) ? $user->image : '';
                if(!empty($old_image) && file_exists($old_image))
                {
                    unlink($old_image);
                }

                // Insert New Image
                $imgname = time().".". $request->file('profile_picture')->getClientOriginalExtension();
                $request->file('profile_picture')->move(public_path('admin_uploads/users/'), $imgname);
                $imageurl = asset('/').'public/admin_uploads/users/'.$imgname;
                $user->image = $imageurl;
            }

            $user->update();
            return redirect()->route('admin.dashboard')->with('success','Profile has been Updated SuccessFully..');
        }
        else
        {
            dd(1);
        }

    }

}
