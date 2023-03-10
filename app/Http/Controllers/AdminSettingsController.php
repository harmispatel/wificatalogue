<?php

namespace App\Http\Controllers;

use App\Models\AdminSettings;
use App\Models\Languages;
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
            'login_form_background',
            'default_light_theme_image',
            'default_dark_theme_image',
            'theme_main_screen_demo',
            'theme_category_screen_demo',
            'default_special_item_image',
        ]);

        $settings = [];

        foreach($keys as $key)
        {
            $query = AdminSettings::select('value')->where('key',$key)->first();
            $settings[$key] = isset($query->value) ? $query->value : '';
        }

        // Languages
        $languages = Languages::where('status',1)->get();

        return view('admin.settings.settings',compact('settings','languages'));
    }


    public function update(Request $request)
    {
        // Validation
        $request->validate([
            'favourite_client_limit'      =>          'required|numeric',
            'copyright_text'              =>          'required',
            'logo'                        =>          'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            'login_form_background'       =>          'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            'default_light_theme_image'       =>          'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            'default_dark_theme_image'       =>          'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            'theme_main_screen_demo'       =>          'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            'theme_category_screen_demo'       =>          'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            'default_special_item_image'       =>          'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
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

        if($request->hasFile('login_form_background'))
        {
            $bgName = "login_bg_".time().".". $request->file('login_form_background')->getClientOriginalExtension();
            $request->file('login_form_background')->move(public_path('admin_uploads/login_backgrounds/'), $bgName);
            $loginbgUrl = asset('/').'public/admin_uploads/login_backgrounds/'.$bgName;
            $all_data['login_form_background'] = $loginbgUrl;
        }

        if($request->hasFile('default_light_theme_image'))
        {
            $imageName = "light_".time().".". $request->file('default_light_theme_image')->getClientOriginalExtension();
            $request->file('default_light_theme_image')->move(public_path('admin_uploads/def_theme_images/'), $imageName);
            $imageUrl = asset('/').'public/admin_uploads/def_theme_images/'.$imageName;
            $all_data['default_light_theme_image'] = $imageUrl;
        }

        if($request->hasFile('default_dark_theme_image'))
        {
            $imageName = "dark_".time().".". $request->file('default_dark_theme_image')->getClientOriginalExtension();
            $request->file('default_dark_theme_image')->move(public_path('admin_uploads/def_theme_images/'), $imageName);
            $imageUrl = asset('/').'public/admin_uploads/def_theme_images/'.$imageName;
            $all_data['default_dark_theme_image'] = $imageUrl;
        }

        if($request->hasFile('theme_main_screen_demo'))
        {
            $imageName = "main_screen_".time().".". $request->file('theme_main_screen_demo')->getClientOriginalExtension();
            $request->file('theme_main_screen_demo')->move(public_path('admin_uploads/screen_image/'), $imageName);
            $imageUrl = asset('/').'public/admin_uploads/screen_image/'.$imageName;
            $all_data['theme_main_screen_demo'] = $imageUrl;
        }

        if($request->hasFile('theme_category_screen_demo'))
        {
            $imageName = "category_screen_".time().".". $request->file('theme_category_screen_demo')->getClientOriginalExtension();
            $request->file('theme_category_screen_demo')->move(public_path('admin_uploads/screen_image/'), $imageName);
            $imageUrl = asset('/').'public/admin_uploads/screen_image/'.$imageName;
            $all_data['theme_category_screen_demo'] = $imageUrl;
        }

        if($request->hasFile('default_special_item_image'))
        {
            $imageName = "special_item_image_".time().".". $request->file('default_special_item_image')->getClientOriginalExtension();
            $request->file('default_special_item_image')->move(public_path('admin_uploads/special_item_image/'), $imageName);
            $imageUrl = asset('/').'public/admin_uploads/special_item_image/'.$imageName;
            $all_data['default_special_item_image'] = $imageUrl;
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

}
