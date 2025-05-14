<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\IssueProduct;
use Illuminate\Http\Request;
use App\Models\DamageProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\RequisitionReceivedRequest;


class ProductController extends Controller
{
    //Product stock list
    public function productStockList(Request $request)
    {
        $categories = Category::select('id', 'name')->get();
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');
        $fd = $fromDate ? date('Y-m-d', strtotime($fromDate)) : '';
        $td = $toDate ? date('Y-m-d', strtotime($toDate)) : '';
        $categoryId = $request->query('category_id');


        $products = Product::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->get();



        // Calculate total received, issue
        $receivedSums = RequisitionReceivedRequest::when($fd && $td, function ($query) use ($fd, $td) {
            $query->whereDate('created_at', '>=', $fd)->whereDate('created_at', '<=', $td);
        })->where('status', 'approved')
            ->select('product_id', DB::raw('SUM(received_qty) as total_received'))
            ->groupBy('product_id')
            ->pluck('total_received', 'product_id');


        $issueSums = IssueProduct::when($fd && $td, function ($query) use ($fd, $td) {
            $query->whereDate('created_at', '>=', $fd)->whereDate('created_at', '<=', $td);
        })->select('product_id', DB::raw('SUM(unit) as total_issue'))
            ->groupBy('product_id')
            ->pluck('total_issue', 'product_id');

        // Merge data
        $productList = [];

        foreach ($products as $product) {
            $totalReceived = $receivedSums[$product->id] ?? 0;
            $totalIssue = $issueSums[$product->id] ?? 0;
            if ($fromDate && $toDate) {
                if ($totalReceived == 0 && $totalIssue == 0) {
                    continue;
                }
            }
            $productList[] = [
                'available_unit' => $product->unit,
                'category_name' => $product->category->name,
                'parts_no' => $product->parts_no,
                'rack_no' => $product->rack_no,
                'column_no' => $product->column_no,
                'row_no' => $product->row_no,
                'product_name' => $product->name,
                'total_received' => $totalReceived,
                'total_issue' => $totalIssue,
            ];
        }

        return Inertia::render('Products/ProductStockListPage', [
            'productList' => $productList,
            'categories' => $categories,
            'category_name' => $categoryId ? $products[0]->category->name : '',
        ]);
    }


    //list product
    public function listProduct()
    {
        $products = Product::with('category')->latest()->get();
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
            $product = Product::findOrFail($request->product_id);
            $exist_qty = $product->unit;
            $damage_qty = $request->damage ?? 0;
            $issue_qty = $request->issue ?? 0;


            if ($damage_qty > 0) {
                DamageProduct::create([
                    'product_id' => $product->id,
                    'unit' => $damage_qty,
                ]);
            }

            // If only damage was done and no issue
            if ($issue_qty == 0 && $damage_qty > 0) {
                return redirect()->back()->with(['status' => true, 'message' => 'Product damaged successfully']);
            }


            if ($issue_qty > 0) {
                if ($issue_qty <= $exist_qty) {
                    IssueProduct::create([
                        'product_id' => $product->id,
                        'unit' => $issue_qty,
                    ]);

                    $product->decrement('unit', $issue_qty);

                    return redirect()->back()->with(['status' => true, 'message' => 'Product issued successfully']);
                } else {
                    return redirect()->back()->with(['status' => false, 'message' => 'Issue quantity is greater than available quantity']);
                }
            }
            return redirect()->back()->with(['status' => false, 'message' => 'No issue or damage quantity provided']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => false, 'message' => 'Something went wrong']);
        }
    }

    //minimum stock list
    public function minimumProductList(Request $request)
    {

        $products = Product::whereColumn('unit', '<=', 'minimum_stock')->with('category')->latest()->get();
        return Inertia::render('Products/MinimumStockListPage', ['products' => $products]);
    }


    //issue product list
    public function issueProductList(Request $request)
    {
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');

        $issueProducts = IssueProduct::when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            $fd = date('Y-m-d', strtotime($fromDate));
            $td = date('Y-m-d', strtotime($toDate));

            $query->whereDate('created_at', '>=', $fd)
                ->whereDate('created_at', '<=', $td);
        })->with('product')->latest()->paginate(500);

        return Inertia::render('Products/ProductIssuePage', ['issueProducts' => $issueProducts, 'fromDate' => $fromDate, 'toDate' => $toDate]);
    }


    //damage product list
    public function damageProductList(Request $request)
    {
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');

        $damageProducts = DamageProduct::when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            $fd = date('Y-m-d', strtotime($fromDate));
            $td = date('Y-m-d', strtotime($toDate));

            $query->whereDate('created_at', '>=', $fd)
                ->whereDate('created_at', '<=', $td);
        })->with('product')->latest()->paginate(500);
        return Inertia::render('Products/DamageProductPage', ['damageProducts' => $damageProducts]);
    }

    //create product
    public function createProduct(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'unit' => 'required|numeric|min:1',
            'unit_type' => 'required',
            'category_id' => 'required',
            'minimum_stock' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }

        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'unit' => $request->unit,
                'unit_type' => $request->unit_type,
                'minimum_stock' => $request->minimum_stock,
                'parts_no' => $request->parts_no,
                'rack_no' => $request->rack_no,
                'column_no' => $request->column_no,
                'row_no' => $request->row_no
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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'unit' => 'required|numeric|min:1',
            'unit_type' => 'required',
            'category_id' => 'required',
            'minimum_stock' => 'required|numeric|min:1'
        ]);
        if ($validator->fails()) {

            return redirect()->back()->with(['errors' => $validator->errors()]);
        }

        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'unit' => $request->unit,
                'unit_type' => $request->unit_type,
                'minimum_stock' => $request->minimum_stock,
                'parts_no' => $request->parts_no,
                'rack_no' => $request->rack_no,
                'column_no' => $request->column_no,
                'row_no' => $request->row_no
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
}
