<?php

namespace App\Http\Controllers;

use App\Models\AdditionalLanguage;
use App\Models\Category;
use App\Models\LanguageSettings;
use App\Models\Shop;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JetBrains\PhpStorm\Language;

class ShopController extends Controller
{
    public function index($id)
    {
        $shop_id = $id;

        $data['shop_details'] = Shop::where('id',$shop_id)->first();

        $language_setting = clientLanguageSettings($shop_id);
        $primary_lang_id = isset($language_setting['primary_language']) ? $language_setting['primary_language'] : '';
        $language_details = getLangDetails($primary_lang_id);
        $primary_lang_code = isset($language_details['code']) ? $language_details['code'] : 'en';

        // If Session not have locale then set primary lang locale
        if(!session()->has('locale'))
        {
            App::setLocale($primary_lang_code);
            session()->put('locale', $primary_lang_code);
            session()->save();
        }

        // Current Languge Code
        $data['current_lang_code'] = (session()->has('locale')) ? session()->get('locale') : 'en';

        // Get all Categories of Shop
        $data['categories'] = Category::where('shop_id',$shop_id)->orderBy('order_key')->get();

        // Get all Additional Language of Shop
        $data['additional_languages'] = AdditionalLanguage::with(['language'])->where('shop_id',$shop_id)->where('published',1)->get();

        return view('shop.shop',$data);
    }


    // Change Locale
    public function changeShopLocale(Request $request)
    {
        $lang_code = $request->lang_code;

        // If Session not have locale then set primary lang locale
        if(session()->has('locale'))
        {
            App::setLocale($lang_code);
            session()->put('locale', $lang_code);
            session()->save();
        }
        else
        {
            App::setLocale($lang_code);
            session()->put('locale', $lang_code);
            session()->save();
        }

        return response()->json([
            'success' => 1,
        ]);
    }


    // Search Categories
    public function searchCategories(Request $request)
    {
        $shop_id = decrypt($request->shopID);
        $keyword = $request->keywords;

        // Current Languge Code
        $current_lang_code = (session()->has('locale')) ? session()->get('locale') : 'en';

        $name_key = $current_lang_code."_name";


        try
        {
            $categories = Category::where("$name_key",'LIKE','%'.$keyword.'%')->where('shop_id',$shop_id)->get();
            $html = '';

            if(count($categories) > 0)
            {
                $html .= '<div class="menu_list">';

                foreach($categories as $category)
                {
                    $category_name = (isset($category->$name_key)) ? $category->$name_key : '';

                    if(!empty($category->image) && file_exists('public/client_uploads/categories/'.$category->image))
                    {
                        $image = asset('public/client_uploads/categories/'.$category->image);
                    }
                    else
                    {
                        $image = asset('public/client_images/not-found/no_image_1.jpg');
                    }

                    $html .= '<div class="menu_list_item">';
                        $html .= '<a>';
                            $html .= '<img src="'.$image.'" class="w-100">';
                            $html .= '<h3 class="item_name">'.$category_name.'</h3>';
                        $html .= '</img>';
                    $html .= '</div>';

                }

                $html .= '</div>';
            }
            else
            {
                $html .= '<h3 class="text-center">Categories not Found.</h3>';
            }

            return response()->json([
                'success' => 1,
                'message' => "Categories has been retrived Successfully...",
                'data'    => $html,
            ]);

        }
        catch (\Throwable $th)
        {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}
