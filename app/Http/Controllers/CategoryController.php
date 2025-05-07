<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    //list category
    public function listCategory(){
       return $categories=Category::all();
        return Inertia::render('Category/CategoryList',['categories'=>$categories]);
    }

    //category save page
    public function categorySavePage(Request $request){
        $categoryId=$request->category_id;
        $category=Category::where('id',$categoryId)->first();
        return Inertia::render('Category/CategorySavePage',['category'=>$category]);
    }


    //create category
    public function createCategory(Request $request){
        $request->validate([
            'name'=>'required'
        ]);
         Category::create([
            'name'=>$request->name
        ]);
        return redirect()->back()->with(['status'=>true,'message'=>'Category created successfully']);
    }

    //update category
    public function updateCategory(Request $request){
        $request->validate([
            'name'=>'required'
        ]);
        Category::where('id',$request->category_id)->update([
            'name'=>$request->name
        ]);
        return redirect()->back()->with(['status'=>true,'message'=>'Category updated successfully']);
    }

    //delete category
    public function deleteCategory(Request $request){
        Category::where('id',$request->category_id)->delete();
        return redirect()->back()->with(['status'=>true,'message'=>'Category deleted successfully']);
    }
}
