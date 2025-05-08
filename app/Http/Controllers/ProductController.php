<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\IssueProduct;
use Illuminate\Http\Request;
use App\Models\DamageProduct;
use Illuminate\Support\Facades\DB;
use App\Models\RequisitionReceivedRequest;

class ProductController extends Controller
{
    //Product stock list
    public function productStockList()
    {
        $products = Product::get();

        // Calculate total received, issue
        $receivedSums = RequisitionReceivedRequest::where('status', 'approved')
            ->select('product_id', DB::raw('SUM(received_qty) as total_received'))
            ->groupBy('product_id')
            ->pluck('total_received', 'product_id');

        $issueSums = IssueProduct::select('product_id', DB::raw('SUM(unit) as total_issue'))
            ->groupBy('product_id')
            ->pluck('total_issue', 'product_id');

        // Merge data
        $productList = [];

        foreach ($products as $product) {
            $productList[] = [
                'available_unit' => $product->unit,
                'product_name' => $product->name,
                'total_received' => $receivedSums[$product->id] ?? 0,
                'total_issue' => $issueSums[$product->id] ?? 0,

            ];
        }

        return Inertia::render('Products/ProductStockListPage', [
            'productList' => $productList
        ]);
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
