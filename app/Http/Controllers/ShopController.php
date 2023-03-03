<?php

namespace App\Http\Controllers;

use App\Models\AdditionalLanguage;
use App\Models\Category;
use App\Models\CategoryProductTags;
use App\Models\Items;
use App\Models\LanguageSettings;
use App\Models\Shop;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JetBrains\PhpStorm\Language;

class ShopController extends Controller
{

    // function for shop Preview
    public function index($slug)
    {
        $shop_slug = $slug;

        $data['shop_details'] = Shop::where('shop_slug',$shop_slug)->first();

        $shop_id = isset($data['shop_details']->id) ? $data['shop_details']->id : '';

        if($data['shop_details'])
        {

            $language_setting = clientLanguageSettings($shop_id);
            $primary_lang_id = isset($language_setting['primary_language']) ? $language_setting['primary_language'] : '';
            $data['primary_language_details'] = getLangDetails($primary_lang_id);
            $primary_lang_code = isset($data['primary_language_details']->code ) ? $data['primary_language_details']->code  : 'en';

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
        else
        {
            return redirect()->route('login');
        }
    }



    // function for shop's Items Preview
    public function itemPreview($shop_slug,$cat_id)
    {
        // Shop Details
        $data['shop_details'] = Shop::where('shop_slug',$shop_slug)->first();

        // Shop ID
        $shop_id = isset($data['shop_details']->id) ? $data['shop_details']->id : '';

        // Category Details
        $data['cat_details'] = Category::where('shop_id',$shop_id)->where('id',$cat_id)->first();


        // CategoryItem Tags
        $data['cat_tags'] = CategoryProductTags::join('tags','tags.id','category_product_tags.tag_id')->orderBy('tags.order')->where('category_id',$cat_id)->get()->unique('tag_id');

        // Get all Categories
        $data['categories'] = Category::orderBy('order_key')->get();

        // Primary Language Details
        $language_setting = clientLanguageSettings($shop_id);
        $primary_lang_id = isset($language_setting['primary_language']) ? $language_setting['primary_language'] : '';
        $data['primary_language_details'] = getLangDetails($primary_lang_id);

        // Current Languge Code
        $data['current_lang_code'] = (session()->has('locale')) ? session()->get('locale') : 'en';

        $data['all_items'] = Items::where('category_id',$cat_id)->orderBy('order_key')->get();

        if($data['cat_details'] && $data['shop_details'])
        {
            // Get all Additional Language of Shop
            $data['additional_languages'] = AdditionalLanguage::with(['language'])->where('shop_id',$shop_id)->where('published',1)->get();

            return view('shop.item_preview',$data);
        }
        else
        {
            return redirect()->back()->with('error',"Oops, Something Went Wrong !");
        }

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
