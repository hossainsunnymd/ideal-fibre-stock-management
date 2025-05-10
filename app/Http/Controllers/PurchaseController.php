<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PurchaseProduct;

class PurchaseController extends Controller
{
    //list purchase
    public function listPurchase()
    {

       $purchases = PurchaseProduct::get();
        return Inertia::render('Purchase/PurchaseListPage', ['purchases' => $purchases]);
    }

    //purchase save page
    public function purchaseSavePage(Request $request)
    {   $products=Product::with('category')->get();
        $purchase_id = $request->query('purchase_id');
        $purchaseProduct = PurchaseProduct::where('id', $purchase_id)->first();
        return Inertia::render('Purchase/PurchaseSavePage', ['purchaseProduct' => $purchaseProduct,'products'=>$products]);
    }

    //create purchase
    public function createPurchase(Request $request){
        $request->validate([
            'product_name' => 'required',
            'unit' => 'required',
        ]);

        $data=[
            'product_name'=>$request->product_name,
            'unit'=>$request->unit,
            'unit_type'=>$request->unit_type
        ];
        try {
            PurchaseProduct::create($data);
            return redirect()->back()->with(['status' => true, 'message' => 'Purchase created successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }

    }

    //update purchase
    public function updatePurchase(Request $request){
        $request->validate([
            'product_name' => 'required',
            'unit' => 'required',
        ]);

        $data=[
            'product_name'=>$request->product_name,
            'unit'=>$request->unit,
            'unit_type'=>$request->unit_type
        ];
        try {
            PurchaseProduct::where('id', $request->purchase_id)->update($data);
            return redirect()->back()->with(['status' => true, 'message' => 'Purchase updated successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }

    //delete purchase
    public function deletePurchase(Request $request){
        try {
            PurchaseProduct::where('id', $request->purchase_id)->delete();
            return redirect()->back()->with(['status' => true, 'message' => 'Product deleted successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }
}
