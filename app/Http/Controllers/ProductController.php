<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Product stock list
    public function productStockList(){
       return Inertia::render('Welcome');
    }

    //list product
    public function listProduct(){
        $products=Product::all();
        return Inertia::render('Product/ProductList',['products'=>$products]);
    }

    //product save page
    public function productSavePage(Request $request){
        $productId=$request->product_id;
        $product=Product::where('id',$productId)->first();
        return Inertia::render('Product/ProductSavePage',['product'=>$product]);
    }

    //create product
    public function createProduct(Request $request){
        $request->validate([
            'name'=>'required',
            'unit'=>'required',
            'unit_type'=>'required',
        ]);

        try{
            $data=[
                'name'=>$request->name,
                'category_id'=>$request->category_id,
                'unit'=>$request->unit,
                'unit_type'=>$request->unit_type
            ];
            Product::create($data);
            return redirect()->back()->with(['status'=>true,'message'=>'Product created successfully']);
        }catch(Exception $e){
            return redirect()->back()->with(['status'=>false,'message'=>'somethintg went wrong']);
        }
    }

    //update product
    public function updateProduct(Request $request){
        $request->validate([
            'name'=>'required',
            'unit'=>'required',
            'unit_type'=>'required',
        ]);

        try{
            $data=[
                'name'=>$request->name,
                'category_id'=>$request->category_id,
                'unit'=>$request->unit,
                'unit_type'=>$request->unit_type
            ];
          Product::where('id',$request->product_id)->update($data);
            return redirect()->back()->with(['status'=>true,'message'=>'Product updated successfully']);
        }catch(Exception $e){
            return redirect()->back()->with(['status'=>false,'message'=>'somethintg went wrong']);
        }
    }

    //delete product
    public function deleteProduct(Request $request){
        Product::where('id',$request->product_id)->delete();
        return redirect()->back()->with(['status'=>true,'message'=>'Product deleted successfully']);
    }
}
