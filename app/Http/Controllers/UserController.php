<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\ClientSettings;
use App\Models\Languages;
use App\Models\LanguageSettings;
use App\Models\Shop;
use App\Models\Subscriptions;
use App\Models\Theme;
use App\Models\ThemeSettings;
use App\Models\User;
use App\Models\UserShop;
use App\Models\UsersSubscriptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    public function index()
    {
        $settings = getAdminSettings();
        $favourite_client_limit = isset($settings['favourite_client_limit']) ? $settings['favourite_client_limit'] : 5;

        $data['clients'] = FavClients($favourite_client_limit);
        return view('admin.clients.clients',$data);
    }



    public function clientsList($id="")
    {
        $settings = getAdminSettings();
        $favourite_client_limit = isset($settings['favourite_client_limit']) ? $settings['favourite_client_limit'] : 5;

        if(empty($id))
        {
            $data['clients'] = User::with(['hasOneShop','hasOneSubscription'])->where('user_type',2)->get();
        }
        else
        {
            $data['clients'] = User::with(['hasOneShop','hasOneSubscription'])->where('id',$id)->get();
        }

        return view('admin.clients.clients_list',$data);
    }



    public function insert()
    {
        $data['subscriptions'] = Subscriptions::where('status',1)->get();
        $data['languages'] = Languages::get();
        return view('admin.clients.new_clients',$data);
    }



    public function store(ClientRequest $request)
    {
        $subscription_id = $request->subscription;
        $primary_language = $request->primary_language;

        $subscription = Subscriptions::where('id',$subscription_id)->first();
        $subscription_duration = isset($subscription->duration) ? $subscription->duration : '';

        $date = Carbon::now();
        $current_date = $date->toDateTimeString();
        $end_date = $date->addMonths($subscription_duration)->toDateTimeString();
        $duration = $subscription_duration.' Months.';

        $username = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $status = (isset($request->status)) ? $request->status : 0;
        $shop_name = $request->shop_name;
        $shop_slug = strtolower(str_replace(' ','_',$shop_name));
        $shop_description = $request->shop_description;

        // Insert New Client
        $client = new User();
        $client->name = $username;
        $client->email = $email;
        $client->password = $password;
        $client->status = $status;
        $client->user_type = 2;
        $client->is_fav = (isset($request->favourite)) ? $request->favourite : 0;
        $client->save();

        if($client->id)
        {
            // Insert Client Shop
            $shop = new Shop();
            $shop->name = $shop_name;
            $shop->shop_slug = $shop_slug;
            $shop->description = $shop_description;

            if($request->hasFile('shop_logo'))
            {
                $path = public_path('admin_uploads/shops/').$shop_slug."/";
                $imgname = time().".". $request->file('shop_logo')->getClientOriginalExtension();
                $request->file('shop_logo')->move($path, $imgname);
                $imageurl = asset('public/admin_uploads/shops/'.$shop_slug).'/'.$imgname;
                $shop->logo = $imageurl;
                $shop->directory = $path;
            }
            $shop->save();

            // Shop's Default Currency
            $default_currency = new ClientSettings();
            $default_currency->client_id = $client->id;
            $default_currency->shop_id = $shop->id;
            $default_currency->key = 'default_currency';
            $default_currency->value = "EUR";
            $default_currency->save();

            // Business Name
            $business_name = new ClientSettings();
            $business_name->client_id = $client->id;
            $business_name->shop_id = $shop->id;
            $business_name->key = $shop_name;
            $business_name->value = "EUR";
            $business_name->save();

            // Generate Shop Qr
            $new_shop_url = URL::to('/')."/".$shop_slug;
            $qr_name = $shop_slug."_".time()."_qr.png";
            $upload_path = public_path('admin_uploads/shops_qr/'.$qr_name);

            QrCode::format('png')->size(200)->generate($new_shop_url, $upload_path);

            // Update Shop Details
            $update_shop_dt = Shop::find($shop->id);
            $update_shop_dt->qr_code = $qr_name;
            $update_shop_dt->update();

            // Insert Default Themes
            $def_themes = [
                'Default Light Theme',
                'Default Dark Theme',
            ];

            foreach ($def_themes as $key => $value)
            {
                $theme = new Theme();
                $theme->shop_id = $shop->id;
                $theme->name = $value;
                $theme->is_default = 1;
                $theme->save();

                // Insert Theme Settings
                if($value == 'Default Light Theme')
                {
                    $setting_keys = [
                        'header_color' => '#ffffff',
                        'sticky_header' => 1,
                        'language_bar_position' => 'left',
                        'logo_position' => 'center',
                        'search_box_position' => 'right',
                        'banner_position' => 'top',
                        'banner_type' => 'image',
                        'background_color' => '#ffffff',
                        'font_color' => '#4d572b',
                        'label_color' => '#ffffff',
                        'social_media_icon_color' => '#4d572b',
                        'categories_bar_color' => '#ffffff',
                        'menu_bar_font_color' => '#4d572b',
                        'category_title_and_description_color' => '#4d572b',
                        'price_color' => '#000000',
                        'item_devider' => 1,
                        'devider_color' => '#d1ccb8',
                        'devider_thickness' => '5px',
                        'tag_font_color' => '#4d572b',
                        'tag_label_color' => '#ffffff',
                        'item_devider_font_color' => '#4d572b',
                    ];

                    foreach($setting_keys as $key => $val)
                    {
                        $theme_setting = new ThemeSettings();
                        $theme_setting->theme_id = $theme->id;
                        $theme_setting->key = $key;
                        $theme_setting->value = $val;
                        $theme_setting->save();
                    }

                    // Client's Active Theme
                    $active_theme = new ClientSettings();
                    $active_theme->client_id = $client->id;
                    $active_theme->shop_id = $shop->id;
                    $active_theme->key = 'shop_active_theme';
                    $active_theme->value = $theme->id;
                    $active_theme->save();
                }
                else
                {
                    $setting_keys = [
                        'header_color' => '#000000',
                        'sticky_header' => 1,
                        'language_bar_position' => 'left',
                        'logo_position' => 'center',
                        'search_box_position' => 'right',
                        'banner_position' => 'top',
                        'banner_type' => 'image',
                        'background_color' => '#000000',
                        'font_color' => '#ffffff',
                        'label_color' => '#000000',
                        'social_media_icon_color' => '#ffffff',
                        'categories_bar_color' => '#000000',
                        'menu_bar_font_color' => '#E7B76B',
                        'category_title_and_description_color' => '#ffffff',
                        'price_color' => '#E7B76B',
                        'item_devider' => 1,
                        'devider_color' => '#E7B76B',
                        'devider_thickness' => '5px',
                        'tag_font_color' => '#ffffff',
                        'tag_label_color' => '#000000',
                        'item_devider_font_color' => '#ffffff',
                    ];

                    foreach($setting_keys as $key => $val)
                    {
                        $theme_setting = new ThemeSettings();
                        $theme_setting->theme_id = $theme->id;
                        $theme_setting->key = $key;
                        $theme_setting->value = $val;
                        $theme_setting->save();
                    }
                }

            }

            // Add Client Default Language
            $primary_lang = new LanguageSettings();
            $primary_lang->shop_id = $shop->id;
            $primary_lang->key = "primary_language";
            $primary_lang->value = $primary_language;
            $primary_lang->save();

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

        return redirect()->route('clients.list')->with('success','Client has been Inserted SuccessFully....');

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
        $status = isset($request->status) ? $request->status : 0;
        $shop_id = $request->shop_id;
        $shop_name = $request->shop_name;
        $shop_slug = strtolower(str_replace(' ','_',$shop_name));
        $shop_description = $request->shop_description;

        // Update New Client
        $client = User::find($request->client_id);
        $client->name = $username;
        $client->email = $email;
        $client->is_fav = (isset($request->favourite)) ? $request->favourite : 0;

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
        $shop->shop_slug = $shop_slug;
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

            $path = public_path('admin_uploads/shops/').$shop_slug."/";
            $imgname = time().".". $request->file('shop_logo')->getClientOriginalExtension();
            $request->file('shop_logo')->move($path, $imgname);
            $imageurl = asset('public/admin_uploads/shops/'.$shop_slug).'/'.$imgname;
            $shop->logo = $imageurl;
            $shop->directory = $path;
        }
        $shop->update();

        return redirect()->route('clients.list')->with('success','Client has been Updated SuccessFully....');
    }



    public function destroy($id)
    {
        // Get User Details
        $user = User::with(['hasOneShop'])->where('id',$id)->first();
        $shop_id = isset($user->hasOneShop->shop['id']) ? $user->hasOneShop->shop['id'] : '';

        if(!empty($shop_id))
        {
            $shop = Shop::where('id',$shop_id)->first();
            $shop_directory = isset($shop->directory) ? $shop->directory : '';

            if(!empty($shop_directory))
            {
                File::deleteDirectory($shop_directory);
            }


            Shop::where('id',$shop_id)->delete();
        }

        // Delete UserShop
        UserShop::where('user_id',$id)->delete();

        // Delete User
        User::where('id',$id)->delete();

        // Delete Users Subscription
        UsersSubscriptions::where('user_id',$id)->delete();

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
        if(Auth::user()->user_type == 1)
        {
            $data['user'] = User::where('id',decrypt($id))->first();
            return view('auth.admin-profile',$data);
        }
        else
        {
            $data['user'] = User::with(['hasOneShop','hasOneSubscription'])->where('id',decrypt($id))->first();
            return view('auth.client-profile',$data);
        }
    }



    public function updateProfile(Request $request)
    {
        $user  = User::find($request->user_id);

        if(Auth::user()->user_type == 1)
        {
            $request->validate([
                'name'                  =>      'required',
                'email'                 =>      'required|email|unique:users,email,'.$request->user_id,
                'confirm_password'      =>      'same:password',
                'profile_picture'       =>      'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG'
            ]);

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
            $request->validate([
                'shop_name'             =>      'required',
                'name'                  =>      'required',
                'email'                 =>      'required|email|unique:users,email,'.$request->user_id,
                'confirm_password'      =>      'same:password',
                'profile_picture'       =>      'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
                'shop_logo'             =>      'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            ]);

            // User Update
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

            // Shop Update
            $shop_id = isset($user->hasOneShop->shop['id']) ? $user->hasOneShop->shop['id'] : '';

            if(!empty($shop_id))
            {
                $shop_slug = strtolower(str_replace(' ','_',$request->shop_name));
                $shop = Shop::find($shop_id);
                $shop->name = $request->shop_name;
                $shop->description = $request->shop_description;

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

                    $path = public_path('admin_uploads/shops/').$shop_slug."/";
                    $imgname = time().".". $request->file('shop_logo')->getClientOriginalExtension();
                    $request->file('shop_logo')->move($path, $imgname);
                    $imageurl = asset('public/admin_uploads/shops/'.$shop_slug).'/'.$imgname;
                    $shop->logo = $imageurl;
                    $shop->directory = $path;
                }
                $shop->update();
            }

            return redirect()->back()->with('success','Profile has been Updated SuccessFully..');
        }

    }



    public function changeStatus(Request $request)
    {
        // Client ID & Status
        $client_id = $request->id;
        $status = $request->status;

        try
        {
            $client = User::find($client_id);
            $client->status = $status;
            $client->update();

            return response()->json([
                'success' => 1,
            ]);

        }
        catch (\Throwable $th)
        {
            return response()->json([
                'success' => 0,
            ]);
        }
    }



    public function addToFavClients(Request $request)
    {
        // Client ID & isFav
        $client_id = $request->id;
        $status = $request->status;

        try
        {
            $client = User::find($client_id);
            $client->is_fav = $status;
            $client->update();

            return response()->json([
                'success' => 1,
            ]);

        }
        catch (\Throwable $th)
        {
            return response()->json([
                'success' => 0,
            ]);
        }
    }



    // Admin Users
    public function AdminUsers()
    {
        $data['users'] = User::where('user_type',1)->get();
        return view('admin.admins.admins',$data);
    }



    // New Admin Users
    public function NewAdminUser()
    {
        return view('admin.admins.new_admin');
    }



    // Store Admin Users
    public function storeNewAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'user_image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $status = isset($request->status) ? $request->status : 0;

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->user_type = 1;
        $user->status = $status;

        if($request->hasFile('user_image'))
        {
            // Insert New Image
            $imgname = time().".". $request->file('user_image')->getClientOriginalExtension();
            $request->file('user_image')->move(public_path('admin_uploads/users/'), $imgname);
            $imageurl = asset('/').'public/admin_uploads/users/'.$imgname;
            $user->image = $imageurl;
        }

        $user->save();

        return redirect()->route('admins')->with('success','Admin has been Inserted SuccessFully....');

    }



    // Delete Admin Users
    public function destroyAdminUser($id)
    {
        // Get User Details
        $user = User::where('id',$id)->first();
        $user_image = isset($user->image) ? $user->image : '';
        if(!empty($user_image) && file_exists($user_image))
        {
            unlink($user_image);
        }

        // Delete User
        User::where('id',$id)->delete();

        return redirect()->route('admins')->with('success','Admin has been Removed SuccessFully..');
    }



    // Edit Admin Users
    public function editAdmin($id)
    {
       try
       {
            $data['user'] = User::where('id',$id)->first();

            if($data['user'])
            {
                return view('admin.admins.edit_admin',$data);
            }
            return redirect()->route('admins')->with('error', 'Something went wrong!');
       }
       catch (\Throwable $th)
       {
            return redirect()->route('admins')->with('error', 'Something went wrong!');
       }
    }



    // Update Admin
    public function updateAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
            'confirm_password' => 'same:password',
            'user_image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $status = isset($request->status) ? $request->status : 0;

        $user = User::find($request->user_id);
        $user->name = $name;
        $user->email = $email;

        if(!empty($password))
        {
            $user->password = $password;
        }

        $user->status = $status;

        if($request->hasFile('user_image'))
        {
            // Insert New Image
            $imgname = time().".". $request->file('user_image')->getClientOriginalExtension();
            $request->file('user_image')->move(public_path('admin_uploads/users/'), $imgname);
            $imageurl = asset('/').'public/admin_uploads/users/'.$imgname;
            $user->image = $imageurl;
        }

        $user->update();

        return redirect()->route('admins')->with('success','Admin has been Updated SuccessFully....');
    }

}
