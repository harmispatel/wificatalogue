<?php

namespace App\Http\Controllers;

use App\Models\ClientSettings;
use App\Models\Theme;
use App\Models\ThemeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $data['shop_id'] = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

        $data['themes'] = Theme::where('shop_id',$data['shop_id'])->get();
        return view('client.design.theme',$data);
    }


    // Display a listing of the resource.
    public function themePrview($id)
    {

        // Theme Details
        $theme = Theme::where('id',$id)->first();

        // Keys
        $keys = ([
            'header_color',
            'sticky_header',
            'language_bar_position',
            'logo_position',
            'search_box_position',
            'banner_position',
            'banner_type',
            'background_color',
            'font_color',
            'label_color',
            'social_media_icon_color',
            'categories_bar_color',
            'menu_bar_font_color',
            'category_title_and_description_color',
            'price_color',
            'item_devider',
            'devider_color',
            'devider_thickness',
            'tag_font_color',
            'tag_label_color',
            'item_devider_font_color',
            'category_bar_type',
            'today_special_icon',
            'theme_preview_image',
        ]);

        $settings = [];

        foreach($keys as $key)
        {
            $query = ThemeSettings::select('value')->where('key',$key)->where('theme_id',$id)->first();
            $settings[$key] = isset($query->value) ? $query->value : '';
        }

        return view('client.design.theme_preview',compact(['settings','theme']));
    }



    // Show the form for creating a new resource.
    public function create()
    {
        return view('client.design.new-theme');
    }


    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'theme_name' => 'required',
            'today_special_icon' => 'mimes:png,jpg,svg,gif,jpeg,PNG,SVG,JPG,JPEG,GIF',
            'theme_preview_image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
        ]);

        // Shop ID
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
        $theme_name = $request->theme_name;

        // Insert New Theme
        $theme = new Theme();
        $theme->shop_id = $shop_id;
        $theme->name = $theme_name;
        $theme->is_default = false;
        $theme->save();

        $setting_keys = [
            'header_color' => $request->header_color,
            'sticky_header' => isset($request->sticky_header) ? $request->sticky_header : 0,
            'language_bar_position' => $request->language_bar_position,
            'logo_position' => $request->logo_position,
            'search_box_position' => $request->search_box_position,
            'banner_position' => $request->banner_position,
            'banner_type' => $request->banner_type,
            'background_color' => $request->background_color,
            'font_color' => $request->font_color,
            'label_color' => $request->label_color,
            'social_media_icon_color' => $request->social_media_icon_color,
            'categories_bar_color' => $request->categories_bar_color,
            'menu_bar_font_color' => $request->menu_bar_font_color,
            'category_title_and_description_color' => $request->category_title_and_description_color,
            'price_color' => $request->price_color,
            'item_devider' => isset($request->item_devider) ? $request->item_devider : 0,
            'devider_color' => $request->devider_color,
            'devider_thickness' => $request->devider_thickness,
            'tag_font_color' => $request->tag_font_color,
            'tag_label_color' => $request->tag_label_color,
            'item_devider_font_color' => $request->item_devider_font_color,
            'category_bar_type' => $request->category_bar_type,
        ];

        if($request->hasFile('today_special_icon'))
        {
            $imgname = "today_special_icon_".time().".". $request->file('today_special_icon')->getClientOriginalExtension();
            $request->file('today_special_icon')->move(public_path('client_uploads/today_special_icon/'), $imgname);
            $setting_keys['today_special_icon'] = $imgname;
        }

        if($request->hasFile('theme_preview_image'))
        {
            $imgname = "theme_preview_image_".time().".". $request->file('theme_preview_image')->getClientOriginalExtension();
            $request->file('theme_preview_image')->move(public_path('client_uploads/theme_preview_image/'), $imgname);
            $setting_keys['theme_preview_image'] = $imgname;
        }

        if($theme->id)
        {
            foreach($setting_keys as $key => $val)
            {
                $theme_setting = new ThemeSettings();
                $theme_setting->theme_id = $theme->id;
                $theme_setting->key = $key;
                $theme_setting->value = $val;
                $theme_setting->save();
            }
        }

        return redirect()->route('design.theme')->with('success','New Theme has been Inserted SuccessFully...');

    }



    // Change Current Theme
    public function changeTheme(Request $request)
    {
        $client_id = isset(Auth::user()->id) ? Auth::user()->id : '';
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
        $theme_id = $request->theme_id;

        $query = ClientSettings::where('shop_id',$shop_id)->where('client_id',$client_id)->where('key','shop_active_theme')->first();
        $setting_id = isset($query->id) ? $query->id : '';

        // Client's Active Theme
        $active_theme = ClientSettings::find($setting_id);
        $active_theme->value = $theme_id;
        $active_theme->update();

        return response()->json([
            'success' => 1,
            'message' => 'Theme has been Activated SuccessFully...',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function edit(Theme $theme)
    {
        //
    }


    // Update the specified resource in storage.
    public function update(Request $request)
    {
        $request->validate([
            'theme_name' => 'required',
            'today_special_icon' => 'mimes:png,jpg,svg,gif,jpeg,PNG,SVG,JPG,JPEG,GIF',
            'theme_preview_image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
        ]);

        // Theme ID
        $theme_id = $request->theme_id;

        // Update Theme Name
        $theme = Theme::find($theme_id);
        $theme->name = $request->theme_name;
        $theme->update();

        $setting_keys = [
            'header_color' => $request->header_color,
            'sticky_header' => isset($request->sticky_header) ? $request->sticky_header : 0,
            'language_bar_position' => $request->language_bar_position,
            'logo_position' => $request->logo_position,
            'search_box_position' => $request->search_box_position,
            'banner_position' => $request->banner_position,
            'banner_type' => $request->banner_type,
            'background_color' => $request->background_color,
            'font_color' => $request->font_color,
            'label_color' => $request->label_color,
            'social_media_icon_color' => $request->social_media_icon_color,
            'categories_bar_color' => $request->categories_bar_color,
            'menu_bar_font_color' => $request->menu_bar_font_color,
            'category_title_and_description_color' => $request->category_title_and_description_color,
            'price_color' => $request->price_color,
            'item_devider' => isset($request->item_devider) ? $request->item_devider : 0,
            'devider_color' => $request->devider_color,
            'devider_thickness' => $request->devider_thickness,
            'tag_font_color' => $request->tag_font_color,
            'tag_label_color' => $request->tag_label_color,
            'item_devider_font_color' => $request->item_devider_font_color,
            'category_bar_type' => $request->category_bar_type,
        ];

        if($request->hasFile('today_special_icon'))
        {
            $imgname = "today_special_icon_".time().".". $request->file('today_special_icon')->getClientOriginalExtension();
            $request->file('today_special_icon')->move(public_path('client_uploads/today_special_icon/'), $imgname);
            $setting_keys['today_special_icon'] = $imgname;
        }

        if($request->hasFile('theme_preview_image'))
        {
            $imgname = "theme_preview_image_".time().".". $request->file('theme_preview_image')->getClientOriginalExtension();
            $request->file('theme_preview_image')->move(public_path('client_uploads/theme_preview_image/'), $imgname);
            $setting_keys['theme_preview_image'] = $imgname;
        }

        // Update Theme Settings
        foreach($setting_keys as $key => $value)
        {
            $query = ThemeSettings::where('key',$key)->where('theme_id',$theme_id)->first();
            $setting_id = isset($query->id) ? $query->id : '';

            // Update
            if(!empty($setting_id) || $setting_id != '')
            {
                $settings = ThemeSettings::find($setting_id);
                $settings->value = $value;
                $settings->update();
            }
            else
            {
                $settings = new ThemeSettings();
                $settings->theme_id = $theme_id;
                $settings->key = $key;
                $settings->value = $value;
                $settings->save();
            }
        }

        return redirect()->back()->with('success', 'Theme Settings has been Changed SuccessFully...');
    }



    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Delete Theme Settings
        ThemeSettings::where('theme_id',$id)->delete();

        // Delete Theme
        Theme::where('id',$id)->delete();

        return redirect()->route('design.theme')->with('success','Theme has been Removed SuccessFully..');
    }


    // Clone Theme View
    public function cloneView($id)
    {
        // Theme Details
        $theme = Theme::where('id',$id)->first();

        // Keys
        $keys = ([
            'header_color',
            'sticky_header',
            'language_bar_position',
            'logo_position',
            'search_box_position',
            'banner_position',
            'banner_type',
            'background_color',
            'font_color',
            'label_color',
            'social_media_icon_color',
            'categories_bar_color',
            'menu_bar_font_color',
            'category_title_and_description_color',
            'price_color',
            'item_devider',
            'devider_color',
            'devider_thickness',
            'tag_font_color',
            'tag_label_color',
            'item_devider_font_color',
            'category_bar_type',
            'today_special_icon',
            'theme_preview_image'
        ]);

        $settings = [];

        foreach($keys as $key)
        {
            $query = ThemeSettings::select('value')->where('key',$key)->where('theme_id',$id)->first();
            $settings[$key] = isset($query->value) ? $query->value : '';
        }

        return view('client.design.theme.clone',compact(['theme','settings']));
    }
}
