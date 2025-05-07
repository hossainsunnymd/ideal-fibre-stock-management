<?php

namespace App\Http\Controllers;

use App\Models\DamageProduct;
use App\Models\IssueProduct;
use App\Models\RequisitionReceivedRequest;
use Exception;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Product stock list
    public function productStockList(){
        $products=Product::all();
        $porductList=[];
        foreach($products as $product){
            $data=[
                'availale_unit'=>$product->unit,
                'product_name'=>$product->name,
                'total_received'=>RequisitionReceivedRequest::where('product_id',$product->id)->where('status','approved')->sum('received_qty'),
                'total_issue'=>IssueProduct::where('product_id',$product->id)->sum('unit'),
                'total_damage'=>DamageProduct::where('product_id',$product->id)->sum('unit'),
            ];
            array_push($porductList,$data);
        }

        return $porductList;
    }


    //list product
    public function listProduct(){
        return $products=Product::all();
        return Inertia::render('Product/ProductList',['products'=>$products]);
    }

    //product save page
    public function productSavePage(Request $request){
        $productId=$request->product_id;
        $product=Product::where('id',$productId)->first();
        return Inertia::render('Product/ProductSavePage',['product'=>$product]);
    }

    //issue product

    public function issueProduct(Request $request){
      try{
        Product::where('id',$request->product_id)->decrement('unit',$request->issue);
        if($request->damage>0){
           DamageProduct::create([
               'product_id'=>$request->product_id,
               'unit'=>$request->damage
           ]);
           IssueProduct::create([
               'product_id'=>$request->product_id,
               'unit'=>$request->issue
           ]);
        }
        return " product issue successfully";
      }catch(Exception $e){
        return "something went wrong". $e->getMessage();

      }
    }

    //issue product list
    public function issueProductList(){
        return $issueProducts=IssueProduct::with('product')->get();
    }

    //damage product list
    public function damageProductList(){
        return $damageProducts=DamageProduct::with('product')->get();
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
