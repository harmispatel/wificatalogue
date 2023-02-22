<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryProductTags;
use App\Models\Ingredient;
use App\Models\Items;
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
            'image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG|dimensions:width=400,height=400',
        ]);

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
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
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
            $item->en_name = $name;
            $item->en_calories = $calories;
            $item->en_description = $description;
            $item->published = $published;
            $item->price = $price;
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



    // Function for Update Existing Item
    public function update(Request $request)
    {

        $request->validate([
            'name'   => 'required',
            'image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG|dimensions:width=400,height=400',
            'category'   => 'required',
        ]);

        $category_id = $request->category;
        $item_id = $request->item_id;
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
            $item = Items::find($item_id);
            $item->category_id = $category_id;
            $item->en_name = $name;
            $item->en_calories = $calories;
            $item->en_description = $description;
            $item->published = $published;
            $item->price = $price;
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