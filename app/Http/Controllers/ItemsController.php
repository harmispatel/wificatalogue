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
            $data['cat_tags'] = CategoryProductTags::join('tags','tags.id','category_product_tags.tag_id')->orderBy('tags.order')->where('category_id',$id)->get()->unique('tag_id');
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
                        $tag->$item_name_key = strtolower($val);
                        $tag->update();
                    }
                    else
                    {
                        $max_order = Tags::max('order');
                        $order = (isset($max_order) && !empty($max_order)) ? ($max_order + 1) : 1;

                        $tag = new Tags();
                        $tag->name = strtolower($val);
                        $tag->$item_name_key = strtolower($val);
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
        $item_id = $request->id;
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

        try
        {
            // Categories
            $categories = Category::get();

            // Ingredients
            $ingredients = Ingredient::get();

            // Tags
            $tags = Tags::get();

            // Item Details
            $item = Items::where('id',$item_id)->first();
            $default_image = asset('public/client_images/not-found/no_image_1.jpg');
            $item_image = (isset($item['image']) && !empty($item['image']) && file_exists('public/client_uploads/items/'.$item['image'])) ? asset('public/client_uploads/items/'.$item['image']) : $default_image;
            $item_published = (isset($item['published']) && $item['published'] == 1) ? 'checked' : '';
            $item_is_new = (isset($item['is_new']) && $item['is_new'] == 1) ? 'checked' : '';
            $item_as_sign = (isset($item['as_sign']) && $item['as_sign'] == 1) ? 'checked' : '';
            $item_day_special = (isset($item['day_special']) && $item['day_special'] == 1) ? 'checked' : '';
            $item_type = (isset($item['type'])) ? $item['type'] : '';
            $category_id = (isset($item['category_id'])) ? $item['category_id'] : '';
            $item_ingredients = (isset($item['ingredients']) && !empty($item['ingredients'])) ? unserialize($item['ingredients']) : [];
            $item_cat_tags = CategoryProductTags::with(['hasOneTag'])->where('item_id',$item['id'])->where('category_id',$item['category_id'])->get();

            // Item Category Tags Array
            if(count($item_cat_tags) > 0)
            {
                foreach ($item_cat_tags as $key => $value)
                {
                    $tag_data[] = isset($value->hasOneTag['name']) ? $value->hasOneTag['name'] : '';
                }
            }
            else
            {
                $tag_data = [];
            }

            // Get Language Settings
            $language_settings = clientLanguageSettings($shop_id);
            $primary_lang_id = isset($language_settings['primary_language']) ? $language_settings['primary_language'] : '';

            // Primary Language Details
            $primary_language_detail = Languages::where('id',$primary_lang_id)->first();
            $primary_lang_code = isset($primary_language_detail->code) ? $primary_language_detail->code : '';
            $primary_lang_name = isset($primary_language_detail->name) ? $primary_language_detail->name : '';

            // Primary Language Category Details
            $primary_item_name = isset($item[$primary_lang_code."_name"]) ? $item[$primary_lang_code."_name"] : '';
            $primary_item_calories = isset($item[$primary_lang_code."_calories"]) ? $item[$primary_lang_code."_calories"] : '';
            $primary_item_desc = isset($item[$primary_lang_code."_description"]) ? $item[$primary_lang_code."_description"] : '';
            $primary_item_price = isset($item[$primary_lang_code."_price"]) ? unserialize($item[$primary_lang_code."_price"]) : [];
            $primary_input_lang_code = "'$primary_lang_code'";

            // Additional Languages
            $additional_languages = AdditionalLanguage::where('shop_id',$shop_id)->get();

            if(count($additional_languages) > 0)
            {
                $html = '';

                // Dynamic Lang Navbar
                $html .= '<ul class="nav nav-tabs" id="myTab" role="tablist">';
                    // For Primary Language
                    $html .= '<li class="nav-item" role="presentation">';
                        $html .= '<button title="'.$primary_lang_name.'" class="nav-link active" id="'.$primary_lang_code.'-tab" data-bs-toggle="tab" data-bs-target="#'.$primary_lang_code.'" type="button" role="tab" aria-controls="'.$primary_lang_code.'" aria-selected="true">'.strtoupper($primary_lang_code).'</button>';
                    $html .= '</li>';

                    // For Additional Language
                    foreach($additional_languages as $value)
                    {
                        // Additional Language Details
                        $add_lang_detail = Languages::where('id',$value->language_id)->first();
                        $add_lang_code = isset($add_lang_detail->code) ? $add_lang_detail->code : '';
                        $add_lang_name = isset($add_lang_detail->name) ? $add_lang_detail->name : '';
                        $add_input_lang_code = "'$add_lang_code'";

                        $html .= '<li class="nav-item" role="presentation">';
                            $html .= '<button title="'.$add_lang_name.'" class="nav-link" id="'.$add_lang_code.'-tab" data-bs-toggle="tab" data-bs-target="#'.$add_lang_code.'" type="button" role="tab" aria-controls="'.$add_lang_code.'" aria-selected="true">'.strtoupper($add_lang_code).'</button>';
                        $html .= '</li>';
                    }
                $html .= '</ul>';


                // Navbar Div
                $html .= '<div class="tab-content" id="myTabContent">';
                    // For Primary Language
                    $html .= '<div class="tab-pane fade show active mt-3" id="'.$primary_lang_code.'" role="tabpanel" aria-labelledby="'.$primary_lang_code.'-tab">';
                        $html .= '<form id="'.$primary_lang_code.'_item_form" enctype="multipart/form-data">';
                            $html .= csrf_field();
                            $html .= '<input type="hidden" name="lang_code" id="lang_code" value="'.$primary_lang_code.'">';
                            $html .= '<input type="hidden" name="item_id" id="item_id" value="'.$item['id'].'">';
                            $html .= '<div class="row">';
                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<label class="form-label" for="type">Type</label>';
                                    $html .= '<select name="type" id="type" class="form-select">';
                                        $html .= '<option value="1"';
                                            if($item_type == 1)
                                            {
                                                $html .= 'selected';
                                            }
                                        $html .='>Product</option>';
                                        $html .= '<option value="2"';
                                            if($item_type == 2)
                                            {
                                                $html .= 'selected';
                                            }
                                        $html .= '>Devider</option>';
                                    $html .= '</select>';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<label class="form-label" for="category">Category</label>';
                                    $html .= '<select name="category" id="category" class="form-select">';
                                            $html .= '<option value="">Choose Category</option>';
                                            if(count($categories) > 0)
                                            {
                                                foreach ($categories as $cat)
                                                {
                                                    $html .= '<option value="'.$cat['id'].'"';
                                                        if($category_id == $cat['id'])
                                                        {
                                                            $html .= 'selected';
                                                        }
                                                    $html .= '>'.$cat[$primary_lang_code."_name"].'</option>';
                                                }
                                            }
                                    $html .= '</select>';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<label class="form-label" for="item_name">Name</label>';
                                    $html .= '<input type="text" name="item_name" id="item_name" class="form-control" value="'.$primary_item_name.'">';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<label class="form-label" for="item_description">Desription</label>';
                                    $html .= '<textarea name="item_description" id="item_description" class="form-control" rows="3">'.$primary_item_desc.'</textarea>';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<label class="form-label" for="item_image">Image</label>';
                                    $html .= '<input type="file" name="item_image" id="item_image" class="form-control">';
                                    $html .= '<div class="mt-3" id="itemImage">';
                                        $html .= '<img src="'.$item_image.'" width="100">';
                                    $html .= '</div>';
                                    $html .= '<code>Upload Image in (200*200) Dimensions</code>';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<label class="form-label" for="ingredients">Ingredients</label>';
                                    $html .= '<select name="ingredients[]" id="'.$primary_lang_code.'_ingredients" class="form-select" multiple>';
                                        if(count($ingredients) > 0)
                                        {
                                            foreach($ingredients as $ing)
                                            {
                                                $html .= '<option value="'.$ing["id"].'"';
                                                    if(in_array($ing["id"],$item_ingredients))
                                                    {
                                                        $html .= 'selected';
                                                    }
                                                $html .='>'.$ing["name"].'</option>';
                                            }
                                        }
                                    $html .= '</select>';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<label class="form-label" for="tags">Tags</label>';
                                    $html .= '<select name="tags[]" id="'.$primary_lang_code.'_tags" class="form-select" multiple>';
                                        if(count($tags) > 0)
                                        {
                                            foreach($tags as $tag)
                                            {
                                                $html .= '<option value="'.$tag["name"].'"';
                                                    if(in_array($tag["name"],$tag_data))
                                                    {
                                                        $html .= 'selected';
                                                    }
                                                $html .='>'.$tag["name"].'</option>';
                                            }
                                        }
                                    $html .= '</select>';
                                $html .= '</div>';

                                $html .= '<div class="form-group priceDiv mb-3" id="priceDiv">';
                                    $html .= '<label class="form-label">Price</label>';
                                    if(isset($primary_item_price['price']) && count($primary_item_price['price']) > 0)
                                    {
                                        foreach($primary_item_price['price'] as $key => $item_price)
                                        {
                                            $price_label = isset($primary_item_price['label'][$key]) ? $primary_item_price['label'][$key] : '';
                                            $price_count = $key + 1;

                                            $html .= '<div class="row mb-3 align-items-center price price_'.$price_count.'">';
                                                $html .= '<div class="col-md-5 mb-1">';
                                                    $html .= '<input type="text" name="price[price][]" class="form-control" placeholder="Enter Price" value="'.$item_price.'">';
                                                $html .= '</div>';
                                                $html .= '<div class="col-md-6 mb-1">';
                                                    $html .= '<input type="text" name="price[label][]" class="form-control" placeholder="Enter Price Label" value="'.$price_label.'">';
                                                $html .= '</div>';
                                                $html .= '<div class="col-md-1 mb-1">';
                                                    $html .= '<a onclick="$(\'.price_'.$price_count.'\').remove()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                                                $html .= '</div>';
                                            $html .= '</div>';
                                        }
                                    }
                                $html .= '</div>';

                                $html .= '<div class="form-group priceDiv mb-3">';
                                    $html .= '<a onclick="addPrice(\''.$primary_lang_code.'_item_form\')" class="btn addPriceBtn btn-info text-white">Add Price</a>';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<label class="form-label" for="calories">Calories</label>';
                                    $html .= '<input type="text" name="calories" id="calories" class="form-control" value="'.$primary_item_calories.'">';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<div class="row">';
                                        $html .= '<div class="col-md-6 mb-2">';
                                            $html .= '<label class="switch me-2">';
                                                $html .= '<input type="checkbox" id="mark_new" name="is_new" value="1" '.$item_is_new.'>';
                                                $html .= '<span class="slider round">';
                                                    $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                                    $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                                $html .= '</span>';
                                            $html .= '</label>';
                                            $html .= '<label for="mark_new" class="form-label">Mark Item as New</label>';
                                        $html .= '</div>';
                                        $html .= '<div class="col-md-6 mb-2">';
                                            $html .= '<label class="switch me-2">';
                                                $html .= '<input type="checkbox" id="mark_sign" name="is_sign" value="1" '.$item_as_sign.'>';
                                                $html .= '<span class="slider round">';
                                                    $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                                    $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                                $html .= '</span>';
                                            $html .= '</label>';
                                            $html .= '<label for="mark_sign" class="form-label">Mark Item as Signature</label>';
                                        $html .= '</div>';
                                    $html .= '</div>';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<div class="row">';
                                        $html .= '<div class="col-md-6 mb-2">';
                                            $html .= '<label class="switch me-2">';
                                                $html .= '<input type="checkbox" id="day_special" name="day_special" value="1" '.$item_day_special.'>';
                                                $html .= '<span class="slider round">';
                                                    $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                                    $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                                $html .= '</span>';
                                            $html .= '</label>';
                                            $html .= '<label for="day_special" class="form-label">Mark Item as Day Special</label>';
                                        $html .= '</div>';
                                        $html .= '<div class="col-md-6 mb-2">';
                                            $html .= '<label class="switch me-2">';
                                                $html .= '<input type="checkbox" id="publish" name="published" value="1" '.$item_published.'>';
                                                $html .= '<span class="slider round">';
                                                    $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                                    $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                                $html .= '</span>';
                                            $html .= '</label>';
                                            $html .= '<label for="publish" class="form-label">Published</label>';
                                        $html .= '</div>';
                                    $html .= '</div>';
                                $html .= '</div>';

                                $html .= '<div class="form-group mb-3">';
                                    $html .= '<a class="btn btn btn-success" onclick="updateItem('.$primary_input_lang_code.')">Update</a>';
                                $html .= '</div>';

                            $html .= '</div>';
                        $html .= '</form>';
                    $html .= '</div>';

                    $language_array[] = $primary_lang_code;

                    // For Additional Language
                    foreach($additional_languages as $value)
                    {
                        // Additional Language Details
                        $add_lang_detail = Languages::where('id',$value->language_id)->first();
                        $add_lang_code = isset($add_lang_detail->code) ? $add_lang_detail->code : '';
                        $add_lang_name = isset($add_lang_detail->name) ? $add_lang_detail->name : '';
                        $add_input_lang_code = "'$add_lang_code'";

                        // Additional Language Item Details
                        $add_item_name = isset($item[$add_lang_code."_name"]) ? $item[$add_lang_code."_name"] : '';
                        $add_item_desc = isset($item[$add_lang_code."_description"]) ? $item[$add_lang_code."_description"] : '';
                        $add_item_price = isset($item[$add_lang_code."_price"]) ? unserialize($item[$add_lang_code."_price"]) : '';
                        $add_item_calories = isset($item[$add_lang_code."_calories"]) ? $item[$add_lang_code."_calories"] : '';

                        $html .= '<div class="tab-pane fade mt-3" id="'.$add_lang_code.'" role="tabpanel" aria-labelledby="'.$add_lang_code.'-tab">';
                            $html .= '<form id="'.$add_lang_code.'_item_form" enctype="multipart/form-data">';
                                $html .= csrf_field();
                                $html .= '<input type="hidden" name="lang_code" id="lang_code" value="'.$add_lang_code.'">';
                                $html .= '<input type="hidden" name="item_id" id="item_id" value="'.$item['id'].'">';
                                $html .= '<div class="row">';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<label class="form-label" for="type">Type</label>';
                                        $html .= '<select name="type" id="type" class="form-select">';
                                            $html .= '<option value="1"';
                                                if($item_type == 1)
                                                {
                                                    $html .= 'selected';
                                                }
                                            $html .='>Product</option>';
                                            $html .= '<option value="2"';
                                                if($item_type == 2)
                                                {
                                                    $html .= 'selected';
                                                }
                                            $html .= '>Devider</option>';
                                        $html .= '</select>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<label class="form-label" for="category">Category</label>';
                                        $html .= '<select name="category" id="category" class="form-select">';
                                                $html .= '<option value="">Choose Category</option>';
                                                if(count($categories) > 0)
                                                {
                                                    foreach ($categories as $cat)
                                                    {
                                                        $html .= '<option value="'.$cat['id'].'"';
                                                            if($category_id == $cat['id'])
                                                            {
                                                                $html .= 'selected';
                                                            }
                                                        $html .= '>'.$cat[$add_lang_code."_name"].'</option>';
                                                    }
                                                }
                                        $html .= '</select>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<label class="form-label" for="item_name">Name</label>';
                                        $html .= '<input type="text" name="item_name" id="item_name" class="form-control" value="'.$add_item_name.'">';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<label class="form-label" for="item_description">Desription</label>';
                                        $html .= '<textarea name="item_description" id="item_description" class="form-control" rows="3">'.$add_item_desc.'</textarea>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<label class="form-label" for="item_image">Image</label>';
                                        $html .= '<input type="file" name="item_image" id="item_image" class="form-control">';
                                        $html .= '<div class="mt-3" id="itemImage">';
                                            $html .= '<img src="'.$item_image.'" width="100">';
                                        $html .= '</div>';
                                        $html .= '<code>Upload Image in (200*200) Dimensions</code>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<label class="form-label" for="ingredients">Ingredients</label>';
                                        $html .= '<select name="ingredients[]" id="'.$add_lang_code.'_ingredients" class="form-select" multiple>';
                                            if(count($ingredients) > 0)
                                            {
                                                foreach($ingredients as $ing)
                                                {
                                                    $html .= '<option value="'.$ing["id"].'"';
                                                        if(in_array($ing["id"],$item_ingredients))
                                                        {
                                                            $html .= 'selected';
                                                        }
                                                    $html .='>'.$ing["name"].'</option>';
                                                }
                                            }
                                        $html .= '</select>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<label class="form-label" for="tags">Tags</label>';
                                        $html .= '<select name="tags[]" id="'.$add_lang_code.'_tags" class="form-select" multiple>';
                                            if(count($tags) > 0)
                                            {
                                                foreach($tags as $tag)
                                                {
                                                    $html .= '<option value="'.$tag["name"].'"';
                                                        if(in_array($tag["name"],$tag_data))
                                                        {
                                                            $html .= 'selected';
                                                        }
                                                    $html .='>'.$tag["name"].'</option>';
                                                }
                                            }
                                        $html .= '</select>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group priceDiv mb-3" id="priceDiv">';
                                        $html .= '<label class="form-label">Price</label>';
                                        if(isset($add_item_price['price']) && count($add_item_price['price']) > 0)
                                        {
                                            foreach($add_item_price['price'] as $key => $item_price)
                                            {
                                                $price_label = isset($add_item_price['label'][$key]) ? $add_item_price['label'][$key] : '';
                                                $price_count = $key + 1;

                                                $html .= '<div class="row mb-3 align-items-center price price_'.$price_count.'">';
                                                    $html .= '<div class="col-md-5 mb-1">';
                                                        $html .= '<input type="text" name="price[price][]" class="form-control" placeholder="Enter Price" value="'.$item_price.'">';
                                                    $html .= '</div>';
                                                    $html .= '<div class="col-md-6 mb-1">';
                                                        $html .= '<input type="text" name="price[label][]" class="form-control" placeholder="Enter Price Label" value="'.$price_label.'">';
                                                    $html .= '</div>';
                                                    $html .= '<div class="col-md-1 mb-1">';
                                                        $html .= '<a onclick="$(\'.price_'.$price_count.'\').remove()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                                                    $html .= '</div>';
                                                $html .= '</div>';
                                            }
                                        }
                                    $html .= '</div>';

                                    $html .= '<div class="form-group priceDiv mb-3">';
                                        $html .= '<a onclick="addPrice(\''.$add_lang_code.'_item_form\')" class="btn addPriceBtn btn-info text-white">Add Price</a>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<label class="form-label" for="calories">Calories</label>';
                                        $html .= '<input type="text" name="calories" id="calories" class="form-control" value="'.$add_item_calories.'">';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<div class="row">';
                                            $html .= '<div class="col-md-6 mb-2">';
                                                $html .= '<label class="switch me-2">';
                                                    $html .= '<input type="checkbox" id="mark_new" name="is_new" value="1" '.$item_is_new.'>';
                                                    $html .= '<span class="slider round">';
                                                        $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                                        $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                                    $html .= '</span>';
                                                $html .= '</label>';
                                                $html .= '<label for="mark_new" class="form-label">Mark Item as New</label>';
                                            $html .= '</div>';
                                            $html .= '<div class="col-md-6 mb-2">';
                                                $html .= '<label class="switch me-2">';
                                                    $html .= '<input type="checkbox" id="mark_sign" name="is_sign" value="1" '.$item_as_sign.'>';
                                                    $html .= '<span class="slider round">';
                                                        $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                                        $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                                    $html .= '</span>';
                                                $html .= '</label>';
                                                $html .= '<label for="mark_sign" class="form-label">Mark Item as Signature</label>';
                                            $html .= '</div>';
                                        $html .= '</div>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<div class="row">';
                                            $html .= '<div class="col-md-6 mb-2">';
                                                $html .= '<label class="switch me-2">';
                                                    $html .= '<input type="checkbox" id="day_special" name="day_special" value="1" '.$item_day_special.'>';
                                                    $html .= '<span class="slider round">';
                                                        $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                                        $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                                    $html .= '</span>';
                                                $html .= '</label>';
                                                $html .= '<label for="day_special" class="form-label">Mark Item as Day Special</label>';
                                            $html .= '</div>';
                                            $html .= '<div class="col-md-6 mb-2">';
                                                $html .= '<label class="switch me-2">';
                                                    $html .= '<input type="checkbox" id="publish" name="published" value="1" '.$item_published.'>';
                                                    $html .= '<span class="slider round">';
                                                        $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                                        $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                                    $html .= '</span>';
                                                $html .= '</label>';
                                                $html .= '<label for="publish" class="form-label">Published</label>';
                                            $html .= '</div>';
                                        $html .= '</div>';
                                    $html .= '</div>';

                                    $html .= '<div class="form-group mb-3">';
                                        $html .= '<a class="btn btn btn-success" onclick="updateItem('.$add_input_lang_code.')">Update</a>';
                                    $html .= '</div>';

                                $html .= '</div>';
                            $html .= '</form>';
                        $html .= '</div>';

                        $language_array[] = $add_lang_code;
                    }

                $html .= '</div>';

            }
            else
            {
                $html = '';

                $html .= '<form id="'.$primary_lang_code.'_item_form" enctype="multipart/form-data">';
                    $html .= csrf_field();
                    $html .= '<input type="hidden" name="lang_code" id="lang_code" value="'.$primary_lang_code.'">';
                    $html .= '<input type="hidden" name="item_id" id="item_id" value="'.$item['id'].'">';
                    $html .= '<div class="row">';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<label class="form-label" for="type">Type</label>';
                        $html .= '<select name="type" id="type" class="form-select">';
                            $html .= '<option value="1"';
                                if($item_type == 1)
                                {
                                    $html .= 'selected';
                                }
                            $html .='>Product</option>';
                            $html .= '<option value="2"';
                                if($item_type == 2)
                                {
                                    $html .= 'selected';
                                }
                            $html .= '>Devider</option>';
                        $html .= '</select>';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<label class="form-label" for="category">Category</label>';
                        $html .= '<select name="category" id="category" class="form-select">';
                                $html .= '<option value="">Choose Category</option>';
                                if(count($categories) > 0)
                                {
                                    foreach ($categories as $cat)
                                    {
                                        $html .= '<option value="'.$cat['id'].'"';
                                            if($category_id == $cat['id'])
                                            {
                                                $html .= 'selected';
                                            }
                                        $html .= '>'.$cat[$primary_lang_code."_name"].'</option>';
                                    }
                                }
                        $html .= '</select>';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<label class="form-label" for="item_name">Name</label>';
                        $html .= '<input type="text" name="item_name" id="item_name" class="form-control" value="'.$primary_item_name.'">';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<label class="form-label" for="item_description">Desription</label>';
                        $html .= '<textarea name="item_description" id="item_description" class="form-control" rows="3">'.$primary_item_desc.'</textarea>';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<label class="form-label" for="item_image">Image</label>';
                        $html .= '<input type="file" name="item_image" id="item_image" class="form-control">';
                        $html .= '<div class="mt-3" id="itemImage">';
                            $html .= '<img src="'.$item_image.'" width="100">';
                        $html .= '</div>';
                        $html .= '<code>Upload Image in (200*200) Dimensions</code>';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<label class="form-label" for="ingredients">Ingredients</label>';
                        $html .= '<select name="ingredients[]" id="'.$primary_lang_code.'_ingredients" class="form-select" multiple>';
                            if(count($ingredients) > 0)
                            {
                                foreach($ingredients as $ing)
                                {
                                    $html .= '<option value="'.$ing["id"].'"';
                                        if(in_array($ing["id"],$item_ingredients))
                                        {
                                            $html .= 'selected';
                                        }
                                    $html .='>'.$ing["name"].'</option>';
                                }
                            }
                        $html .= '</select>';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<label class="form-label" for="tags">Tags</label>';
                        $html .= '<select name="tags[]" id="'.$primary_lang_code.'_tags" class="form-select" multiple>';
                            if(count($tags) > 0)
                            {
                                foreach($tags as $tag)
                                {
                                    $html .= '<option value="'.$tag["name"].'"';
                                        if(in_array($tag["name"],$tag_data))
                                        {
                                            $html .= 'selected';
                                        }
                                    $html .='>'.$tag["name"].'</option>';
                                }
                            }
                        $html .= '</select>';
                    $html .= '</div>';

                    $html .= '<div class="form-group priceDiv mb-3" id="priceDiv">';
                        $html .= '<label class="form-label">Price</label>';
                        if(isset($primary_item_price['price']) && count($primary_item_price['price']) > 0)
                        {
                            foreach($primary_item_price['price'] as $key => $item_price)
                            {
                                $price_label = isset($primary_item_price['label'][$key]) ? $primary_item_price['label'][$key] : '';
                                $price_count = $key + 1;

                                $html .= '<div class="row mb-3 align-items-center price price_'.$price_count.'">';
                                    $html .= '<div class="col-md-5 mb-1">';
                                        $html .= '<input type="text" name="price[price][]" class="form-control" placeholder="Enter Price" value="'.$item_price.'">';
                                    $html .= '</div>';
                                    $html .= '<div class="col-md-6 mb-1">';
                                        $html .= '<input type="text" name="price[label][]" class="form-control" placeholder="Enter Price Label" value="'.$price_label.'">';
                                    $html .= '</div>';
                                    $html .= '<div class="col-md-1 mb-1">';
                                        $html .= '<a onclick="$(\'.price_'.$price_count.'\').remove()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                                    $html .= '</div>';
                                $html .= '</div>';
                            }
                        }
                    $html .= '</div>';

                    $html .= '<div class="form-group priceDiv mb-3">';
                            $html .= '<a onclick="addPrice(\''.$primary_lang_code.'_item_form\')" class="btn addPriceBtn btn-info text-white">Add Price</a>';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<label class="form-label" for="calories">Calories</label>';
                        $html .= '<input type="text" name="calories" id="calories" class="form-control" value="'.$primary_item_calories.'">';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<div class="row">';
                            $html .= '<div class="col-md-6 mb-2">';
                                $html .= '<label class="switch me-2">';
                                    $html .= '<input type="checkbox" id="mark_new" name="is_new" value="1" '.$item_is_new.'>';
                                    $html .= '<span class="slider round">';
                                        $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                        $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                    $html .= '</span>';
                                $html .= '</label>';
                                $html .= '<label for="mark_new" class="form-label">Mark Item as New</label>';
                            $html .= '</div>';
                            $html .= '<div class="col-md-6 mb-2">';
                                $html .= '<label class="switch me-2">';
                                    $html .= '<input type="checkbox" id="mark_sign" name="is_sign" value="1" '.$item_as_sign.'>';
                                    $html .= '<span class="slider round">';
                                        $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                        $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                    $html .= '</span>';
                                $html .= '</label>';
                                $html .= '<label for="mark_sign" class="form-label">Mark Item as Signature</label>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<div class="row">';
                            $html .= '<div class="col-md-6 mb-2">';
                                $html .= '<label class="switch me-2">';
                                    $html .= '<input type="checkbox" id="day_special" name="day_special" value="1" '.$item_day_special.'>';
                                    $html .= '<span class="slider round">';
                                        $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                        $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                    $html .= '</span>';
                                $html .= '</label>';
                                $html .= '<label for="day_special" class="form-label">Mark Item as Day Special</label>';
                            $html .= '</div>';
                            $html .= '<div class="col-md-6 mb-2">';
                                $html .= '<label class="switch me-2">';
                                    $html .= '<input type="checkbox" id="publish" name="published" value="1" '.$item_published.'>';
                                    $html .= '<span class="slider round">';
                                        $html .= '<i class="fa-solid fa-circle-check check_icon"></i>';
                                        $html .= '<i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>';
                                    $html .= '</span>';
                                $html .= '</label>';
                                $html .= '<label for="publish" class="form-label">Published</label>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';

                    $html .= '<div class="form-group mb-3">';
                        $html .= '<a class="btn btn btn-success" onclick="updateItem('.$primary_input_lang_code.')">Update</a>';
                    $html .= '</div>';

                    $html .= '</div>';
                $html .= '</form>';

                $language_array[] = $primary_lang_code;

            }

            return response()->json([
                'success' => 1,
                'message' => "Item Details has been Retrived Successfully..",
                'data'=> $html,
                'language_array'=> $language_array,
                'item_type'=> $item_type,
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


    // Function for Update Existing Item
    public function update(Request $request)
    {
        $request->validate([
            'item_name'   => 'required',
            'item_image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
            'category'   => 'required',
        ]);

        $lang_code = $request->lang_code;
        $item_id = $request->item_id;
        $item_type = $request->type;
        $category = $request->category;
        $item_name = $request->item_name;
        $item_description = $request->item_description;
        $item_calories = $request->calories;
        $is_new = isset($request->is_new) ? $request->is_new : 0;
        $is_sign = isset($request->is_sign) ? $request->is_sign : 0;
        $day_special = isset($request->day_special) ? $request->day_special : 0;
        $published = isset($request->published) ? $request->published : 0;

        $price_array['price'] = isset($request->price['price']) ? array_filter($request->price['price']) : [];
        $price_array['label'] = isset($request->price['label']) ? $request->price['label'] : [];

        $ingredients = (isset($request->ingredients) && count($request->ingredients) > 0) ? serialize($request->ingredients) : '';
        $tags = isset($request->tags) ? $request->tags : [];

        if(count($price_array['price']) > 0)
        {
            if($item_type == 1)
            {
                $item_price = serialize($price_array);
            }
            else
            {
                $item_price = NULL;
            }
        }
        else
        {
            $item_price = NULL;
        }


        try
        {
            $name_key = $lang_code."_name";
            $description_key = $lang_code."_description";
            $price_key = $lang_code."_price";
            $calories_key = $lang_code."_calories";

            $item = Items::find($item_id);

            if($item)
            {
                $item->category_id = $category;
                $item->published = $published;
                $item->is_new = $is_new;
                $item->as_sign = $is_sign;
                $item->day_special = $day_special;
                $item->ingredients = $ingredients;

                $item->name = $item_name;
                $item->description = $item_description;
                $item->price = $item_price;
                $item->calories = $item_calories;

                $item->$name_key = $item_name;
                $item->$description_key = $item_description;
                $item->$price_key = $item_price;
                $item->$calories_key = $item_calories;

                // Insert Item Image if is Exists
                if($request->hasFile('item_image'))
                {
                    // Delete old Image
                    $item_image = isset($item->image) ? $item->image : '';
                    if(!empty($item_image) && file_exists('public/client_uploads/items/'.$item_image))
                    {
                        unlink('public/client_uploads/items/'.$item_image);
                    }

                    $imgname = "item_".time().".". $request->file('item_image')->getClientOriginalExtension();
                    $request->file('item_image')->move(public_path('client_uploads/items/'), $imgname);
                    $item->image = $imgname;
                }

                $item->update();

                CategoryProductTags::where('category_id',$item->category_id)->where('item_id',$item->id)->delete();

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
                            $tag->$name_key = strtolower($val);
                            $tag->update();
                        }
                        else
                        {
                            $max_order = Tags::max('order');
                            $order = (isset($max_order) && !empty($max_order)) ? ($max_order + 1) : 1;

                            $tag = new Tags();
                            $tag->name = strtolower($val);
                            $tag->$name_key = strtolower($val);
                            $tag->order = $order;
                            $tag->save();
                        }

                        if($tag->id)
                        {
                            $cat_pro_tag = new CategoryProductTags();
                            $cat_pro_tag->tag_id = $tag->id;
                            $cat_pro_tag->category_id = $item->category_id;
                            $cat_pro_tag->item_id = $item->id;
                            $cat_pro_tag->save();
                        }
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
