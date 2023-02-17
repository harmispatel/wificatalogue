<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Function for Store New Category
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG|dimensions:width=400,height=400',
        ]);

        $name = $request->name;
        $description = $request->description;
        $published = isset($request->published) ? $request->published : 0;
        $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';

       try
       {
            $category = new Category();
            $category->en_name = $name;
            $category->en_description = $description;
            $category->published = $published;
            $category->shop_id = $shop_id;

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
            'image' => 'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG|dimensions:width=400,height=400',
        ]);

        try
        {
            $id = $request->category_id;
            $name = $request->name;
            $description = $request->description;
            $published = isset($request->published) ? $request->published : 0;

            $category = Category::find($id);
            $category->en_name = $name;
            $category->en_description = $description;
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
}
