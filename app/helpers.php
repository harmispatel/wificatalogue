<?php

    use App\Models\AdminSettings;
use App\Models\LanguageSettings;
use App\Models\User;

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



    // Get Favourite Clients List
    function FavClients($limit)
    {
        $clients = User::with(['hasOneShop','hasOneSubscription'])->where('user_type',2)->where('is_fav',1)->limit($limit)->get();
        return $clients;
    }

?>
