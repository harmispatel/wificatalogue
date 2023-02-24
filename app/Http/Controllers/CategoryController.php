<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    // Get all Categories
    public function index()
    {
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
        $data['categories'] = Category::where('shop_id',$shop_id)->orderBy('order_key')->get();
        return view('client.categories.categories',$data);
    }



    // Function for Store New Category
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
        ]);

        // Shop ID
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

        // Language Settings
        $language_settings = clientLanguageSettings($shop_id);
        $primary_lang_id = isset($language_settings['primary_language']) ? $language_settings['primary_language'] : '';

        // Language Details
        $language_detail = Languages::where('id',$primary_lang_id)->first();
        $lang_code = isset($language_detail->code) ? $language_detail->code : '';

        $category_name_key = $lang_code."_name";
        $category_description_key = $lang_code."_description";

        $name = $request->name;
        $description = $request->description;
        $published = isset($request->published) ? $request->published : 0;
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

        $max_category_order_key = Category::max('order_key');
        $category_order = (isset($max_category_order_key) && !empty($max_category_order_key)) ? ($max_category_order_key + 1) : 1;

       try
       {
            $category = new Category();
            $category->en_name = $name;
            $category->en_description = $description;

            $category->$category_name_key = $name;
            $category->$category_description_key = $description;

            $category->published = $published;
            $category->shop_id = $shop_id;
            $category->order_key = $category_order;

            // Insert Category Image if is Exists
            if($request->hasFile('image'))
            {
                $imgname = "category_".time().".". $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('client_uploads/categories/'), $imgname);
                $category->image = $imgname;
            }

            $category->save();

            return response()->json([
                'success' => 1,
                'message' => "Category has been Inserted SuccessFully....",
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



    // Function for Delete Category
    public function destroy(Request $request)
    {
        try
        {
            $id = $request->id;

            $category = Category::where('id',$id)->first();
            $category_image = isset($category->image) ? $category->image : '';

            // Delete Category Image
            if(!empty($category->image) && file_exists('public/client_uploads/categories/'.$category_image))
            {
                unlink('public/client_uploads/categories/'.$category_image);
            }

            // Delete Category
            Category::where('id',$id)->delete();

            return response()->json([
                'success' => 1,
                'message' => "Category has been Deleted SuccessFully....",
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



    // Function for Edit Category
    public function edit(Request $request)
    {
        try
        {
            $id = $request->id;
            $category = Category::where('id',$id)->first();

            return response()->json([
                'success' => 1,
                'message' => "Category Details has been Retrived Successfully..",
                'category'=> $category,
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



    // Function for Update Category
    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG',
        ]);

        // Shop ID
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

        // Language Settings
        $language_settings = clientLanguageSettings($shop_id);
        $primary_lang_id = isset($language_settings['primary_language']) ? $language_settings['primary_language'] : '';

        // Language Details
        $language_detail = Languages::where('id',$primary_lang_id)->first();
        $lang_code = isset($language_detail->code) ? $language_detail->code : '';

        $category_name_key = $lang_code."_name";
        $category_description_key = $lang_code."_description";

        try
        {
            $id = $request->category_id;
            $name = $request->name;
            $description = $request->description;
            $published = isset($request->published) ? $request->published : 0;

            $category = Category::find($id);

            $category->en_name = $name;
            $category->en_description = $description;

            $category->$category_name_key = $name;
            $category->$category_description_key = $description;

            $category->published = $published;

            // Insert Category Image if is Exists
            if($request->hasFile('image'))
            {
                // Delete old Image
                $category_image = isset($category->image) ? $category->image : '';
                if(!empty($category_image) && file_exists('public/client_uploads/categories/'.$category_image))
                {
                    unlink('public/client_uploads/categories/'.$category_image);
                }

                // Insert new Image
                $imgname = "category_".time().".". $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('client_uploads/categories/'), $imgname);
                $category->image = $imgname;
            }

            $category->update();

            return response()->json([
                'success' => 1,
                'message' => "Category has been Updated SuccessFully....",
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



    // Function for Change Category Status
    public function status(Request $request)
    {
        try
        {
            $id = $request->id;
            $published = $request->status;

            $category = Category::find($id);
            $category->published = $published;
            $category->update();

            return response()->json([
                'success' => 1,
                'message' => "Category Status has been Changed Successfully..",
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



    // Function for Filtered Categories
    public function searchCategories(Request $request)
    {
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
        $keyword = $request->keywords;

        try
        {
            $categories = Category::where('en_name','LIKE','%'.$keyword.'%')->where('shop_id',$shop_id)->get();
            $html = '';

            if(count($categories) > 0)
            {
                foreach($categories as $category)
                {
                    $newStatus = ($category->published == 1) ? 0 : 1;
                    $checked = ($category->published == 1) ? 'checked' : '';

                    if(!empty($category->image) && file_exists('public/client_uploads/categories/'.$category->image))
                    {
                        $image = asset('public/client_uploads/categories/'.$category->image);
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
                                    $html .= '<button type="button" class="btn edit_item">ADD OR EDIT ITEMS</button>';
                                    $html .= '<button class="btn edit_category" onclick="editCategory('.$category->id.')">EDIT CATEGORY</button>';
                                $html .= '</div>';
                                $html .= '<a class="delet_bt" onclick="deleteCategory('.$category->id.')" style="cursor: pointer;"><i class="fa-solid fa-trash"></i></a>';
                            $html .= '</div>';
                            $html .= '<div class="item_info">';
                                $html .= '<div class="item_name">';
                                    $html .= '<h3>'.$category->en_name.'</h3>';
                                    $html .= '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" role="switch" id="status" onclick="changeStatus('.$category->id.','.$newStatus.')" value="1" '.$checked.'></div>';
                                $html .= '</div>';
                                $html .= '<h2>Product Category</h2>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';


                }
            }

            $html .= '<div class="col-md-3">';
                $html .= '<div class="item_box">';
                    $html .= '<div class="item_img add_category">';
                        $html .= '<a data-bs-toggle="modal" data-bs-target="#addCategoryModal" class="add_category_bt" id="NewCategoryBtn"><i class="fa-solid fa-plus"></i></a>';
                    $html .= '</div>';
                    $html .= '<div class="item_info text-center"><h2>Product Category</h2></div>';
                $html .= '</div>';
            $html .= '</div>';

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



    // Function for Sorting Category.
    public function sorting(Request $request)
    {
        $sort_array = $request->sortArr;

        foreach ($sort_array as $key => $value)
        {
    		$key = $key+1;
    		Category::where('id',$value)->update(['order_key'=>$key]);
    	}

        return response()->json([
            'success' => 1,
            'message' => "Category has been Sorted SuccessFully....",
        ]);

    }
}
