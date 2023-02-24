<?php

namespace App\Http\Controllers;

use App\Models\AdditionalLanguage;
use App\Models\Category;
use App\Models\CategoryProductTags;
use App\Models\Ingredient;
use App\Models\Items;
use App\Models\Languages;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function index($id="")
    {
        $data['ingredients'] = Ingredient::get();
        $data['tags'] = Tags::get();

        if(!empty($id) || $id != '')
        {
            $data['cat_id'] = $id;
            $data['categories'] = Category::get();
            $data['category'] = Category::where('id',$id)->first();
            $data['items'] = Items::where('category_id',$id)->orderBy('order_key')->get();
            // $data['cat_tags'] = CategoryProductTags::with([ 'hasOneTag'])->where('category_id',$id)->get()->unique('tag_id');
            $data['cat_tags'] = CategoryProductTags::join('tags','tags.id','category_product_tags.tag_id')->orderBy('tags.order')->get()->unique('tag_id');
        }
        else
        {
            $data['cat_id'] = '';
            $data['categories'] = Category::get();
            $data['category'] = "All";
            $data['items'] = Items::orderBy('order_key')->get();
            $data['cat_tags'] = CategoryProductTags::join('tags','tags.id','category_product_tags.tag_id')->orderBy('tags.order')->get()->unique('tag_id');
        }

        return view('client.items.items',$data);
    }



    // Function for Store Newly Create Item
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
        ]);

        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

        // Language Settings
        $language_settings = clientLanguageSettings($shop_id);
        $primary_lang_id = isset($language_settings['primary_language']) ? $language_settings['primary_language'] : '';

        // Language Details
        $language_detail = Languages::where('id',$primary_lang_id)->first();
        $lang_code = isset($language_detail->code) ? $language_detail->code : '';

        $item_name_key = $lang_code."_name";
        $item_price_key = $lang_code."_price";
        $item_calories_key = $lang_code."_calories";
        $item_description_key = $lang_code."_description";

        $max_item_order_key = Items::max('order_key');
        $item_order = (isset($max_item_order_key) && !empty($max_item_order_key)) ? ($max_item_order_key + 1) : 1;

        $category_id = $request->category;
        $type = $request->type;
        $name = $request->name;
        $calories = $request->calories;
        $description = $request->description;
        $is_new = isset($request->is_new) ? $request->is_new : 0;
        $as_sign = isset($request->is_sign) ? $request->is_sign : 0;
        $published = isset($request->published) ? $request->published : 0;
        $day_special = isset($request->day_special) ? $request->day_special : 0;
        $ingredients = (isset($request->ingredients) && count($request->ingredients) > 0) ? serialize($request->ingredients) : '';
        $tags = isset($request->tags) ? $request->tags : [];


        $price_array['price'] = isset($request->price['price']) ? array_filter($request->price['price']) : [];
        $price_array['label'] = isset($request->price['label']) ? $request->price['label'] : [];

        if(count($price_array['price']) > 0)
        {
            $price = serialize($price_array);
        }
        else
        {
            $price = NULL;
        }

        try
        {
            $item = new Items();
            $item->category_id = $category_id;
            $item->shop_id = $shop_id;
            $item->type = $type;

            $item->name = $name;
            $item->price = $price;
            $item->calories = $calories;
            $item->description = $description;

            $item->$item_name_key = $name;
            $item->$item_price_key = $price;
            $item->$item_calories_key = $calories;
            $item->$item_description_key = $description;

            $item->published = $published;
            $item->order_key = $item_order;
            $item->ingredients = $ingredients;
            $item->is_new = $is_new;
            $item->as_sign = $as_sign;
            $item->day_special = $day_special;

            // Insert Item Image if is Exists
            if($request->hasFile('image'))
            {
                $imgname = "item_".time().".". $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('client_uploads/items/'), $imgname);
                $item->image = $imgname;
            }

            $item->save();

            // Insert & Update Tags
            if(count($tags) > 0)
            {
                foreach($tags as $val)
                {
                    $findTag = Tags::where('name',strtolower($val))->first();
                    $tag_id = (isset($findTag->id) && !empty($findTag->id)) ? $findTag->id : '';

                    if(!empty($tag_id) || $tag_id != '')
                    {
                        $tag = Tags::find($tag_id);
                        $tag->name = strtolower($val);
                        $tag->update();
                    }
                    else
                    {
                        $max_order = Tags::max('order');
                        $order = (isset($max_order) && !empty($max_order)) ? ($max_order + 1) : 1;

                        $tag = new Tags();
                        $tag->name = strtolower($val);
                        $tag->order = $order;
                        $tag->save();
                    }

                    if($tag->id)
                    {
                        $cat_pro_tag = new CategoryProductTags();
                        $cat_pro_tag->tag_id = $tag->id;
                        $cat_pro_tag->category_id = $category_id;
                        $cat_pro_tag->item_id = $item->id;
                        $cat_pro_tag->save();
                    }
                }
            }

            return response()->json([
                'success' => 1,
                'message' => "Item has been Inserted SuccessFully....",
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



    // Function for Delete Item
    public function destroy(Request $request)
    {
        try
        {
            $id = $request->id;

            $item = Items::where('id',$id)->first();
            $item_image = isset($item->image) ? $item->image : '';

            // Delete Item Image
            if(!empty($item_image) && file_exists('public/client_uploads/items/'.$item_image))
            {
                unlink('public/client_uploads/items/'.$item_image);
            }

            // Delete Item
            Items::where('id',$id)->delete();

            return response()->json([
                'success' => 1,
                'message' => "Item has been Deleted SuccessFully....",
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



    // Function for Change Item Status
    public function status(Request $request)
    {
        try
        {
            $id = $request->id;
            $published = $request->status;

            $item = Items::find($id);
            $item->published = $published;
            $item->update();

            return response()->json([
                'success' => 1,
                'message' => "Item Status has been Changed Successfully..",
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



    // Function for Filtered Items
    public function searchItems(Request $request)
    {
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
        $keyword = $request->keywords;
        $cat_id = $request->id;

        try
        {
            if(!empty($cat_id))
            {
                $items = Items::where('en_name','LIKE','%'.$keyword.'%')->where('category_id',$cat_id)->where('shop_id',$shop_id)->get();
            }
            else
            {
                $items = Items::where('en_name','LIKE','%'.$keyword.'%')->where('shop_id',$shop_id)->get();
            }
            $html = '';

            if(count($items) > 0)
            {
                foreach($items as $item)
                {
                    $newStatus = ($item->published == 1) ? 0 : 1;
                    $checked = ($item->published == 1) ? 'checked' : '';

                    if(!empty($item->image) && file_exists('public/client_uploads/items/'.$item->image))
                    {
                        $image = asset('public/client_uploads/items/'.$item->image);
                    }
                    else
                    {
                        $image = asset('public/client_images/not-found/no_image_1.jpg');
                    }

                    $html .= '<div class="col-md-3">';
                        $html .= '<div class="item_box">';
                            $html .= '<div class="item_img">';
                                $html .= '<a href="#"><img src="'.$image.'" class="w-100"></a>';
                                $html .= '<div class="edit_item_bt">';
                                    $html .= '<button class="btn edit_category" onclick="editCategory('.$item->id.')">EDIT ITEM</button>';
                                $html .= '</div>';
                                $html .= '<a class="delet_bt" onclick="deleteItem('.$item->id.')" style="cursor: pointer;"><i class="fa-solid fa-trash"></i></a>';
                            $html .= '</div>';
                            $html .= '<div class="item_info">';
                                $html .= '<div class="item_name">';
                                    $html .= '<h3>'.$item->en_name.'</h3>';
                                    $html .= '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" role="switch" id="status" onclick="changeStatus('.$item->id.','.$newStatus.')" value="1" '.$checked.'></div>';
                                $html .= '</div>';
                                $html .= '<h2>Product</h2>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';


                }
            }

            $html .= '<div class="col-md-3">';
                $html .= '<div class="item_box">';
                    $html .= '<div class="item_img add_category">';
                        $html .= '<a data-bs-toggle="modal" data-bs-target="#addItemModal" class="add_category_bt" id="NewItemBtn"><i class="fa-solid fa-plus"></i></a>';
                    $html .= '</div>';
                    $html .= '<div class="item_info text-center"><h2>Product</h2></div>';
                $html .= '</div>';
            $html .= '</div>';

            return response()->json([
                'success' => 1,
                'message' => "Item has been retrived Successfully...",
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



    // Function for Edit Item
    public function edit(Request $request)
    {
        try
        {
            $id = $request->id;
            $item = Items::where('id',$id)->first();

            if($item && !empty($id))
            {
                $item['product_tags'] = CategoryProductTags::with(['hasOneTag'])->where('item_id',$id)->get();
            }
            else
            {
                $item['product_tags'] = [];
            }

            if($item && !empty($item['price']))
            {
                $item['price'] = unserialize($item['price']);
            }

            if($item && !empty($item['ingredients']))
            {
                $item['ingredients'] = unserialize($item['ingredients']);
            }

            return response()->json([
                'success' => 1,
                'message' => "Item Details has been Retrived Successfully..",
                'item'=> $item,
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

    // public function edit(Request $request)
    // {
    //     $item_id = $request->id;
    //     $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

    //     try
    //     {

    //         // Categories
    //         $categories = Category::get();

    //         // Ingredients
    //         $ingredients = Ingredient::get();

    //         // Item Details
    //         $item = Items::where('id',$item_id)->first();
    //         $default_image = asset('public/client_images/not-found/no_image_1.jpg');
    //         $item_image = (isset($item['image']) && !empty($item['image']) && file_exists('public/client_uploads/items/'.$item['image'])) ? asset('public/client_uploads/items/'.$item['image']) : $default_image;
    //         $item_status = (isset($item['published']) && $item['published'] == 1) ? 'checked' : '';
    //         $item_type = (isset($item['type'])) ? $item['type'] : '';
    //         $category_id = (isset($item['category_id'])) ? $item['category_id'] : '';
    //         $item_ingredients = (isset($item['ingredients']) && !empty($item['ingredients'])) ? unserialize($item['ingredients']) : [];

    //         // Get Language Settings
    //         $language_settings = clientLanguageSettings($shop_id);
    //         $primary_lang_id = isset($language_settings['primary_language']) ? $language_settings['primary_language'] : '';

    //         // Primary Language Details
    //         $primary_language_detail = Languages::where('id',$primary_lang_id)->first();
    //         $primary_lang_code = isset($primary_language_detail->code) ? $primary_language_detail->code : '';
    //         $primary_lang_name = isset($primary_language_detail->name) ? $primary_language_detail->name : '';

    //         // Primary Language Category Details
    //         $primary_item_name = isset($item[$primary_lang_code."_name"]) ? $item[$primary_lang_code."_name"] : '';
    //         $primary_item_calories = isset($item[$primary_lang_code."_calories"]) ? $item[$primary_lang_code."_calories"] : '';
    //         $primary_item_desc = isset($item[$primary_lang_code."_description"]) ? $item[$primary_lang_code."_description"] : '';
    //         $primary_input_lang_code = "'$primary_lang_code'";

    //         // Additional Languages
    //         $additional_languages = AdditionalLanguage::where('shop_id',$shop_id)->get();

    //         if(count($additional_languages) > 0)
    //         {

    //         }
    //         else
    //         {
    //             $html = '';

    //             $html .= '<form id="'.$primary_lang_code.'_item_form" enctype="multipart/form-data">';
    //                 $html .= csrf_field();
    //                 $html .= '<input type="hidden" name="lang_code" id="lang_code" value="'.$primary_lang_code.'">';
    //                 $html .= '<input type="hidden" name="item_id" id="item_id" value="'.$item['id'].'">';
    //                 $html .= '<div class="row">';

    //                 $html .= '<div class="form-group mb-3">';
    //                     $html .= '<label class="form-label" for="type">Type</label>';
    //                     $html .= '<select name="type" id="type" class="form-select">';
    //                         $html .= '<option value="1"';
    //                             if($item_type == 1)
    //                             {
    //                                 $html .= 'selected';
    //                             }
    //                         $html .='>Product</option>';
    //                         $html .= '<option value="2"';
    //                             if($item_type == 2)
    //                             {
    //                                 $html .= 'selected';
    //                             }
    //                         $html .= '>Devider</option>';
    //                     $html .= '</select>';
    //                 $html .= '</div>';

    //                 $html .= '<div class="form-group mb-3">';
    //                     $html .= '<label class="form-label" for="category">Category</label>';
    //                     $html .= '<select name="category" id="category" class="form-select">';
    //                             $html .= '<option value="">Choose Category</option>';
    //                             if(count($categories) > 0)
    //                             {
    //                                 foreach ($categories as $cat)
    //                                 {
    //                                     $html .= '<option value="'.$cat['id'].'"';
    //                                         if($category_id == $cat['id'])
    //                                         {
    //                                             $html .= 'selected';
    //                                         }
    //                                     $html .= '>'.$cat[$primary_lang_code."_name"].'</option>';
    //                                 }
    //                             }
    //                     $html .= '</select>';
    //                 $html .= '</div>';

    //                 $html .= '<div class="form-group mb-3">';
    //                     $html .= '<label class="form-label" for="item_name">Name</label>';
    //                     $html .= '<input type="text" name="item_name" id="item_name" class="form-control" value="'.$primary_item_name.'">';
    //                 $html .= '</div>';

    //                 $html .= '<div class="form-group mb-3">';
    //                     $html .= '<label class="form-label" for="item_description">Desription</label>';
    //                     $html .= '<textarea name="item_description" id="item_description" class="form-control" rows="3">'.$primary_item_desc.'</textarea>';
    //                 $html .= '</div>';

    //                 $html .= '<div class="form-group mb-3">';
    //                     $html .= '<label class="form-label" for="item_image">Image</label>';
    //                     $html .= '<input type="file" name="item_image" id="item_image" class="form-control">';
    //                     $html .= '<div class="mt-3" id="itemImage">';
    //                         $html .= '<img src="'.$item_image.'" width="100">';
    //                     $html .= '</div>';
    //                     $html .= '<code>Upload Image in (200*200) Dimensions</code>';
    //                 $html .= '</div>';

    //                 $html .= '<div class="form-group mb-3">';
    //                     $html .= '<label class="form-label" for="ingredients">Ingredients</label>';
    //                     $html .= '<select name="ingredients[]" id="ingredients" class="form-select" multiple>';
    //                         if(count($ingredients) > 0)
    //                         {
    //                             foreach($ingredients as $ing)
    //                             {
    //                                 $html .= '<option value="'.$ing["id"].'"';
    //                                     if(in_array($ing["id"],$item_ingredients))
    //                                     {
    //                                         $html .= 'selected';
    //                                     }
    //                                 $html .='>'.$ing["name"].'</option>';
    //                             }
    //                         }
    //                     $html .= '</select>';
    //                 $html .= '</div>';

    //                 $html .= '</div>';
    //             $html .= '</form>';
    //         }

    //         return response()->json([
    //             'success' => 1,
    //             'message' => "Item Details has been Retrived Successfully..",
    //             'data'=> $html,
    //         ]);
    //     }
    //     catch (\Throwable $th)
    //     {
    //         return response()->json([
    //             'success' => 0,
    //             'message' => "Internal Server Error!",
    //         ]);
    //     }
    // }


    // Function for Update Existing Item
    public function update(Request $request)
    {

        $request->validate([
            'name'   => 'required',
            'image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            'category'   => 'required',
        ]);

        // Shop ID
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

        // Language Settings
        $language_settings = clientLanguageSettings($shop_id);
        $primary_lang_id = isset($language_settings['primary_language']) ? $language_settings['primary_language'] : '';

        // Language Details
        $language_detail = Languages::where('id',$primary_lang_id)->first();
        $lang_code = isset($language_detail->code) ? $language_detail->code : '';

        $item_name_key = $lang_code."_name";
        $item_price_key = $lang_code."_price";
        $item_calories_key = $lang_code."_calories";
        $item_description_key = $lang_code."_description";

        $category_id = $request->category;
        $item_id = $request->item_id;
        $name = $request->name;
        $description = $request->description;
        $calories = $request->calories;
        $is_new = isset($request->is_new) ? $request->is_new : 0;
        $as_sign = isset($request->is_sign) ? $request->is_sign : 0;
        $published = isset($request->published) ? $request->published : 0;
        $day_special = isset($request->day_special) ? $request->day_special : 0;
        $ingredients = (isset($request->ingredients) && count($request->ingredients) > 0) ? serialize($request->ingredients) : '';
        $tags = isset($request->tags) ? $request->tags : [];

        $price_array['price'] = isset($request->price['price']) ? array_filter($request->price['price']) : [];
        $price_array['label'] = isset($request->price['label']) ? $request->price['label'] : [];

        if(count($price_array['price']) > 0)
        {
            $price = serialize($price_array);
        }
        else
        {
            $price = NULL;
        }

        try
        {
            $item = Items::find($item_id);
            $item->category_id = $category_id;

            $item->name = $name;
            $item->price = $price;
            $item->calories = $calories;
            $item->description = $description;

            $item->$item_name_key = $name;
            $item->$item_price_key = $price;
            $item->$item_calories_key = $calories;
            $item->$item_description_key = $description;

            $item->published = $published;
            $item->is_new = $is_new;
            $item->as_sign = $as_sign;
            $item->ingredients = $ingredients;
            $item->day_special = $day_special;

            // Insert Item Image if is Exists
            if($request->hasFile('image'))
            {
                // Delete old Image
                $item_image = isset($item->image) ? $item->image : '';
                if(!empty($item_image) && file_exists('public/client_uploads/items/'.$item_image))
                {
                    unlink('public/client_uploads/items/'.$item_image);
                }

                $imgname = "item_".time().".". $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('client_uploads/items/'), $imgname);
                $item->image = $imgname;
            }

            $item->update();

            CategoryProductTags::where('category_id',$category_id)->where('item_id',$item->id)->delete();

            // Insert & Update Tags
            if(count($tags) > 0)
            {

                foreach($tags as $val)
                {
                    $findTag = Tags::where('name',strtolower($val))->first();
                    $tag_id = (isset($findTag->id) && !empty($findTag->id)) ? $findTag->id : '';

                    if(!empty($tag_id) || $tag_id != '')
                    {
                        $tag = Tags::find($tag_id);
                        $tag->name = strtolower($val);
                        $tag->update();
                    }
                    else
                    {
                        $max_order = Tags::max('order');
                        $order = (isset($max_order) && !empty($max_order)) ? ($max_order + 1) : 1;

                        $tag = new Tags();
                        $tag->name = strtolower($val);
                        $tag->order = $order;
                        $tag->save();
                    }

                    if($tag->id)
                    {
                        $cat_pro_tag = new CategoryProductTags();
                        $cat_pro_tag->tag_id = $tag->id;
                        $cat_pro_tag->category_id = $category_id;
                        $cat_pro_tag->item_id = $item->id;
                        $cat_pro_tag->save();
                    }
                }
            }

            return response()->json([
                'success' => 1,
                'message' => "Item has been Updated SuccessFully....",
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


    // Function for Sorting Tags.
    public function sorting(Request $request)
    {
        $sort_array = $request->sortArr;

        foreach ($sort_array as $key => $value)
        {
    		$key = $key+1;
    		Items::where('id',$value)->update(['order_key'=>$key]);
    	}

        return response()->json([
            'success' => 1,
            'message' => "Item has been Sorted SuccessFully....",
        ]);

    }
}
