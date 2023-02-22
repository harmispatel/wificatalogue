<?php

namespace App\Http\Controllers;

use App\Models\CategoryProductTags;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function show(Tags $tags)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit(Request $request)
    {
        try
        {
            $id = $request->id;
            $tag = Tags::where('id',$id)->first();

            return response()->json([
                'success' => 1,
                'message' => "Tag Details has been Retrived Successfully..",
                'tag'=> $tag,
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

    // Update the specified resource in storage.
    public function update(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|unique:tags,name,'.$request->tag_id,
        ]);

        try
        {
            $tag = Tags::find($request->tag_id);
            $tag->name = strtolower($request->tag_name);
            $tag->update();

            return response()->json([
                'success' => 1,
                'message' => "Tag has been Updated SuccessFully....",
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

    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try
        {
            $id = $request->id;

            // Delete Product Tags
            CategoryProductTags::where('tag_id',$id)->delete();

            // Delete Tag
            Tags::where('id',$id)->delete();

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
}
