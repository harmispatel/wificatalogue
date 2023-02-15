<?php

namespace App\Http\Controllers;

use App\Models\AdminSettings;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // Keys
        $keys = ([
            'favourite_client_limit',
            'copyright_text',
            'logo',
        ]);

        $settings = [];

        foreach($keys as $key)
        {
            $query = AdminSettings::select('value')->where('key',$key)->first();
            $settings[$key] = isset($query->value) ? $query->value : '';
        }

        return view('admin.settings.settings',compact('settings'));
    }


    public function update(Request $request)
    {
        // Validation
        $request->validate([
            'favourite_client_limit'      =>          'required|numeric',
            'copyright_text'              =>          'required',
            'logo'                        =>          'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
        ]);

        $all_data['favourite_client_limit'] = $request->favourite_client_limit;
        $all_data['copyright_text'] = $request->copyright_text;

        if($request->hasFile('logo'))
        {
            $logoname = "logo_".time().".". $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('admin_uploads/logos/'), $logoname);
            $logoUrl = asset('/').'public/admin_uploads/logos/'.$logoname;
            $all_data['logo'] = $logoUrl;
        }


        // Insert or Update Settings
        foreach($all_data as $key => $value)
        {
            $query = AdminSettings::where('key',$key)->first();
            $setting_id = isset($query->id) ? $query->id : '';

            if (!empty($setting_id) || $setting_id != '')  // Update
            {
                $settings = AdminSettings::find($setting_id);
                $settings->value = $value;
                $settings->update();
            }
            else // Insert
            {
                $settings = new AdminSettings();
                $settings->key = $key;
                $settings->value = $value;
                $settings->save();
            }
        }

        return redirect()->back()->with('success','Settings has been Updated SuccessFully..');

    }

    // foreach ($data as $key => $new)
    // {
    //     $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
    //     $setting_id = isset($query->setting_id) ? $query->setting_id : '';
    //     if (!empty($setting_id) || $setting_id != '') {
    //         update
    //     }
    //     else{
    //         insert
    //     }
    // }
}
