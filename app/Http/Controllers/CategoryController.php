<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //list category
    public function listCategory(){
        $categories=Category::all();
        return Inertia::render('Category/CategoryListPage',['categories'=>$categories]);
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
            'category_name'=>'required'
        ]);
      try{
         Category::create([
            'name'=>$request->category_name
        ]);
        return redirect()->back()->with(['status'=>true,'message'=>'Category created successfully']);
      }catch(Exception $e){
        return redirect()->back()->with(['status'=>false,'message'=>'somethintg went wrong']);
      }
    }

    //update category
    public function updateCategory(Request $request){
        $request->validate([
            'category_name'=>'required'
        ]);
       try{
        Category::where('id',$request->category_id)->update([
            'name'=>$request->category_name
        ]);
        return redirect()->back()->with(['status'=>true,'message'=>'Category updated successfully']);
       }catch(Exception $e){
        return redirect()->back()->with(['status'=>false,'message'=>'somethintg went wrong']);
       }
    }

    //delete category
    public function deleteCategory(Request $request){
        Category::where('id',$request->category_id)->delete();
        return redirect()->back()->with(['status'=>true,'message'=>'Category deleted successfully']);
    }
}
