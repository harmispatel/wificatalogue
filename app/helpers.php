<?php

    use App\Models\AdminSettings;
use App\Models\User;

    // Get Admin's Settings
    function getAdminSettings()
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

        return $settings;

    }



    // Get Favourite Clients List
    function FavClients($limit)
    {
        $clients = User::with(['hasOneShop','hasOneSubscription'])->where('user_type',2)->where('is_fav',1)->limit($limit)->get();
        return $clients;
    }

?>
