<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Requisition;
use App\Models\RequisitionProduct;
use App\Models\RequisitionReceivedRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisitionController extends Controller
{
    //list requisition
    public function listRequisition()
    {
        return $requitions = Requisition::with('requistionProducts.product')->get();
    }
    //create requisition
    public function createRequisition(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'created_by' => $request->created_by,
                'total_by_kg' => $request->total_by_kg,
                'total_by_pc' => $request->total_by_pc,
                'total_by_feet' => $request->total_by_feet,
                'total_by_coel' => $request->total_by_coel,
            ];
            $products = $request->products;
            $requisition = Requisition::create($data);
            foreach ($products as $product) {
                RequisitionProduct::create([
                    'requisition_id' => $requisition->id,
                    'product_id' => $product['product_id'],
                    'total_requisition' => $product['qty'],
                    'total_received' => 0
                ]);
            }
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return 'something went wrong ' . $e;
        }
    }

    //requisition received request
    public function requisitionReceivedRequest(Request $request)
    {

        RequisitionReceivedRequest::create([
            'requisitionProduct_id' => $request->requisition_product_id,
            'received_qty' => $request->received_qty,
            'product_id' => RequisitionProduct::where('id', $request->requisition_product_id)->first()->product_id
        ]);

        return 'request send successfully';
    }

    //requisition approved request
    public function requisitionApproveRequest(Request $request)
    {

        $receivedRequest = RequisitionReceivedRequest::findOrFail($request->received_id);

        // Update status
        $receivedRequest->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'approved') {
            $qty = $receivedRequest->received_qty;

            // Update requisition product received count
            RequisitionProduct::where('id', $receivedRequest->requisitionProduct_id)
                ->increment('total_received', $qty);

            // Update product stock
            Product::where('id', $receivedRequest->product_id)
                ->increment('unit', $qty);
        }

        return 'Request approved successfully';
    }



    //requisition received request list
    public function requisitionReceivedRequestList()
    {
        return RequisitionReceivedRequest::with('product')->get();
    }

    //requisition product list
    public function requisitionProductList()
    {
        return RequisitionProduct::with('product', 'requisition')->get();
    }


    //delete requistion
    public function deleteRequisition(Request $request)
    {
        try {
            RequisitionProduct::where('requisition_id', $request->requisition_id)->delete();
            Requisition::where('id', $request->requisition_id)->delete();

            return redirect()->back()->with(['status' => true, 'message' => 'Product deleted successfully']);
        } catch (Exception $e) {

            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }
}
