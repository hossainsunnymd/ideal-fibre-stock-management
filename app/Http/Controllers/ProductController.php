<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\IssueProduct;
use Illuminate\Http\Request;
use App\Models\DamageProduct;
use App\Models\PurchaseProduct;
use Illuminate\Support\Facades\DB;
use App\Models\RequisitionReceivedRequest;

class ProductController extends Controller
{
    //Product stock list
    public function productStockList(Request $request)
    {
        $products = Product::get();
        $fromDate =$request->query('fromDate');
        $toDate = $request->query('toDate');

        // Calculate total received, issue
        $receivedSums = RequisitionReceivedRequest::when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            $fd=date('Y-m-d', strtotime($fromDate));
            $td=date('Y-m-d', strtotime($toDate));
            $query->whereDate('created_at', '>=', $fd)->whereDate('created_at', '<=', $td);
        })
            ->where('status', 'approved')
            ->select('product_id', DB::raw('SUM(received_qty) as total_received'))
            ->groupBy('product_id')
            ->pluck('total_received', 'product_id');


        $issueSums = IssueProduct::when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            $fd=date('Y-m-d', strtotime($fromDate));
            $td=date('Y-m-d', strtotime($toDate));
            $query->whereDate('created_at', '>=', $fd)->whereDate('created_at', '<=', $td);
        })
            ->select('product_id', DB::raw('SUM(unit) as total_issue'))
            ->groupBy('product_id')
            ->pluck('total_issue', 'product_id');

        // Merge data
        $productList = [];

        foreach ($products as $product) {
            $totalReceived = $receivedSums[$product->id] ?? 0;
            $totalIssue = $issueSums[$product->id] ?? 0;
            if($fromDate && $toDate){
                if($totalReceived ==0 && $totalIssue ==0){
                continue;
            }
            }


            $productList[] = [
                'available_unit' => $product->unit,
                'product_name' => $product->name,
                'total_received' => $totalReceived,
                'total_issue' => $totalIssue,
            ];
        }

        return Inertia::render('Products/ProductStockListPage', [
            'productList' => $productList,
        ]);
    }


    //list product
    public function listProduct()
    {
        $products = Product::with('category')->get();
        return Inertia::render('Products/ProductListPage', ['products' => $products]);
    }

    //product save page
    public function productSavePage(Request $request)
    {
        $productId = $request->product_id;
        $product = Product::where('id', $productId)->first();
        $category = Category::all();
        return Inertia::render('Products/ProductSavePage', ['product' => $product, 'category' => $category]);
    }
    // product issue page
    public function productIssuePage(Request $request)
    {
        return Inertia::render('Products/ProductDamageIssuePage');
    }

    //issue product
    public function issueProduct(Request $request)
    {

        try {
            Product::where('id', $request->product_id)->decrement('unit', $request->issue);
            if ($request->damage > 0) {
                DamageProduct::create([
                    'product_id' => $request->product_id,
                    'unit' => $request->damage
                ]);
            }
            IssueProduct::create([
                'product_id' => $request->product_id,
                'unit' => $request->issue
            ]);
            return redirect()->back()->with(['status' => true, 'message' => 'Product issued successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }

    //issue product list
    public function issueProductList()
    {
        $issueProducts = IssueProduct::with('product')->get();
        return Inertia::render('Products/ProductIssuePage', ['issueProducts' => $issueProducts]);
    }

    //damage product list
    public function damageProductList()
    {
        $damageProducts = DamageProduct::with('product')->get();
        return Inertia::render('Products/DamageProductPage', ['damageProducts' => $damageProducts]);
    }

    //create product
    public function createProduct(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'unit_type' => 'required',
            'category_id' => 'required'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'unit' => $request->unit,
                'unit_type' => $request->unit_type
            ];
            Product::create($data);
            return redirect()->back()->with(['status' => true, 'message' => 'Product created successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }

    //update product
    public function updateProduct(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'unit_type' => 'required',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'unit' => $request->unit,
                'unit_type' => $request->unit_type
            ];
            Product::where('id', $request->product_id)->update($data);
            return redirect()->back()->with(['status' => true, 'message' => 'Product updated successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }

    //delete product
    public function deleteProduct(Request $request)
    {
        try {
            Product::where('id', $request->product_id)->delete();
            return redirect()->back()->with(['status' => true, 'message' => 'Product deleted successfully']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }


    //list purchase
    public function listPurchase()
    {

       $purchases = PurchaseProduct::get();
        return Inertia::render('Purchase/PurchaseListPage', ['purchases' => $purchases]);
    }

    //purchase save page
    public function purchaseSavePage(Request $request)
    {
        $purchase_id = $request->query('purchase_id');
        $purchaseProduct = PurchaseProduct::where('id', $purchase_id)->first();
        return Inertia::render('Purchase/PurchaseSavePage', ['purchaseProduct' => $purchaseProduct]);
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
