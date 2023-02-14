<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserShop;
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
        return view('admin.clients.new_clients');
    }

    public function store(ClientRequest $request)
    {
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
        $username = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $status = $request->status;
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

        // Update Client Shop
        // $shop = Shop::;
        // $shop->name = $shop_name;
        // $shop->description = $shop_description;

        // if($request->hasFile('shop_logo'))
        // {
        //     $imgname = time().".". $request->file('shop_logo')->getClientOriginalExtension();
        //     $request->file('shop_logo')->move(public_path('admin_uploads/shop/'), $imgname);
        //     $imageurl = asset('/').$imgname;
        //     $shop->logo = $imageurl;
        // }

        return redirect()->route('clients')->with('success','Client has been Updated SuccessFully....');
    }


    public function destroy($id)
    {
        // Delete User
        User::where('id',$id)->delete();

        // Delete UserShop
        UserShop::where('user_id',$id)->delete();

        return redirect()->route('clients')->with('success','Client has been Removed SuccessFully..');
    }


    public function edit($id)
    {
        $data['client'] = User::with(['hasOneShop'])->where('id',$id)->first();
        return view('admin.clients.edit_clients',$data);
    }
}
