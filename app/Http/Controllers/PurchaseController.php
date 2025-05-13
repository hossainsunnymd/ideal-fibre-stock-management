<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PurchaseProduct;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    //list purchase
    public function listPurchase(Request $request)
    {
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');
        $purchases = PurchaseProduct::when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            $fd = date('Y-m-d', strtotime($fromDate));
            $td = date('Y-m-d', strtotime($toDate));
            $query->whereDate('created_at', '>=', $fd)
                ->whereDate('created_at', '<=', $td);
        })->get();
        return Inertia::render('Purchase/PurchaseListPage', ['purchases' => $purchases]);
    }

    //purchase save page
    public function purchaseSavePage(Request $request)
    {
        $products = Product::with('category')->get();
        $purchase_id = $request->query('purchase_id');
        $purchaseProduct = PurchaseProduct::where('id', $purchase_id)->first();
        return Inertia::render('Purchase/PurchaseSavePage', ['purchaseProduct' => $purchaseProduct, 'products' => $products]);
    }

    //create purchase
    public function createPurchase(Request $request)
    {

        $validator = Validator::make($request->all(), [
             'unit' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
           return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $unit_type=Product::where('id',$request->seltected_product_id)->first()->unit_type;
        $data = [
            'product_name' => $request->product_name,
            'unit' => $request->unit,
            'unit_type' => $unit_type
        ];
        try {
            PurchaseProduct::create($data);
            return redirect()->back()->with(['status' => true, 'message' => 'Purchase created successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }

    //update purchase
    public function updatePurchase(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'unit' => 'required',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'unit' => $request->unit,
            'unit_type' => $request->unit_type
        ];
        try {
            PurchaseProduct::where('id', $request->purchase_id)->update($data);
            return redirect()->back()->with(['status' => true, 'message' => 'Purchase updated successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }

    //delete purchase
    public function deletePurchase(Request $request)
    {
        try {
            PurchaseProduct::where('id', $request->purchase_id)->delete();
            return redirect()->back()->with(['status' => true, 'message' => 'Product deleted successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }
}
