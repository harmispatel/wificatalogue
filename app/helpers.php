<?php

    use App\Models\AdminSettings;
use App\Models\CategoryProductTags;
use App\Models\ClientSettings;
use App\Models\Ingredient;
use App\Models\Languages;
use App\Models\LanguageSettings;
use App\Models\ShopBanner;
use App\Models\ThemeSettings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

    // Get Admin's Settings
    function getAdminSettings()
    {
        // Keys
        $keys = ([
            'favourite_client_limit',
            'copyright_text',
            'logo',
            'login_form_background',
        ]);

        $settings = [];

        foreach($keys as $key)
        {
            $query = AdminSettings::select('value')->where('key',$key)->first();
            $settings[$key] = isset($query->value) ? $query->value : '';
        }

        return $settings;
    }


    // Get Client's Settings
    function getClientSettings($shopID="")
    {

        if(!empty($shopID))
        {
            $shop_id = $shopID;
        }
        else
        {
            $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
        }

        // Keys
        $keys = ([
            'shop_view_header_logo',
            'shop_intro_icon',
            'intro_icon_status',
            'intro_icon_duration',
            'business_name',
            'default_currency',
            'business_telephone',
            'instagram_link',
            'twitter_link',
            'facebook_link',
            'foursquare_link',
            'tripadvisor_link',
            'homepage_intro',
            'map_url',
            'website_url',
            'shop_active_theme',
        ]);

        $settings = [];

        foreach($keys as $key)
        {
            $query = ClientSettings::select('value')->where('shop_id',$shop_id)->where('key',$key)->first();
            $settings[$key] = isset($query->value) ? $query->value : '';
        }

        return $settings;
    }


    // Get Client's LanguageSettings
    function clientLanguageSettings($shopID)
    {
        // Keys
        $keys = ([
            'primary_language',
        ]);

        $settings = [];

        foreach($keys as $key)
        {
            $query = LanguageSettings::select('value')->where('key',$key)->where('shop_id',$shopID)->first();
            $settings[$key] = isset($query->value) ? $query->value : '';
        }

        return $settings;
    }


    // Get Theme Settings
    function themeSettings($themeID)
    {
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
        ]);

        $settings = [];

        foreach($keys as $key)
        {
            $query = ThemeSettings::select('value')->where('key',$key)->where('theme_id',$themeID)->first();
            $settings[$key] = isset($query->value) ? $query->value : '';
        }

        return $settings;
    }


    // Get Language Details
    function getLangDetails($langID)
    {
        $language = Languages::where('id',$langID)->first();
        return $language;
    }


    // Get Language Details by Code
    function getLangDetailsbyCode($langCode)
    {
        $language = Languages::where('code',$langCode)->first();
        return $language;
    }


    // Get Tags Product
    function getTagsProducts($tagID,$catID)
    {
        if(!empty($tagID) && !empty($catID))
        {
            // $items = CategoryProductTags::with(['product'])->where('tag_id',$tagID)->where('category_id',$catID)->get();
            $items = CategoryProductTags::join('items','items.id','category_product_tags.item_id')->where('tag_id',$tagID)->where('category_product_tags.category_id',$catID)->orderBy('items.order_key')->get();
        }
        else
        {
            $items = [];
        }
        return $items;
    }


    // Get Ingredients Details
    function getIngredientDetail($id)
    {
        $ingredient = Ingredient::where('id',$id)->first();
        return $ingredient;
    }


    // Get Banner Settings
    function getBannerSetting($shopID)
    {
        $banner = ShopBanner::where('shop_id',$shopID)->where('key','shop_banner')->first();
        return $banner;
    }


    // Get Favourite Clients List
    function FavClients($limit)
    {
        $clients = User::with(['hasOneShop','hasOneSubscription'])->where('user_type',2)->where('is_fav',1)->limit($limit)->get();
        return $clients;
    }

?>
