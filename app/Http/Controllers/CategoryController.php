<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(3);
        return view('admin.category.trash',compact('categories'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(3);
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->parent_id);
        $request->validate([
            'title' => 'required|min:5',
            'slug'  => 'required|min:5|unique:categories,slug'
        ]);

        $categories = Category::create($request->only('title','description','slug'));
        $categories->childrens()->attach($request->parent_id);
        return back()->with('message','Category Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        
        $categories = Category::where('id','!=',$category->id)->get();
        return view('admin.category.create',['categories' =>$categories,'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|min:5',
            'slug'  => 'required|min:5|unique:categories,slug'
        ]);

       $category->title       =  $request->title;
       $category->description =  $request->description;
       $category->slug        =  $request->slug;

       //detach all parent Categories
       $category->childrens()->detach();
       //attach selected parent categories
       $category->childrens()->attach($request->parent_id);
       //save current record into database 
       $saved  =  $category->save();
       //return back to the /add/edit form
       return back()->with('message','Record Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
       //Detach all parent category 
       $category->childrens()->detach();

       if($category->forceDelete())
       {
           return back()->with('message','Record Successfully Deleted');
       }
       else{
           return back()->with('message','Error Deleting Record');
       }
    }
    

    public function remove(Category $category)
    {
        if($category->delete())
        {
            return back()->with('message','Category Successfully Trashed');
        }
        else{
            return back()->with('message','Error Deleting Record');
        }
    }

    public function recoverCat($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if($category->restore())
            return back()
                     ->with('message','Category Successfully Restored!');
        else
            return back()->with('message','Error Restoring Category');
    }


}
