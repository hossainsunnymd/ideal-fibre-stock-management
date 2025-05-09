<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Requisition;
use App\Models\RequisitionProduct;
use App\Models\RequisitionReceivedRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RequisitionController extends Controller
{
    //list requisition
    public function listRequisition()
    {
        $requisitions = Requisition::get();
        return Inertia::render('Requisition/RequisitionListPage', ['requisitions' => $requisitions]);
    }
    //create requisition
    public function createRequisition(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'created_by' =>'superadmin',
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
                    'product_id' => $product['id'],
                    'total_requisition' => $product['requisition_qty'],
                    'total_received' => 0
                ]);
                Product::where('id', $product['id'])->decrement('unit', $product['requisition_qty']);
            }
            DB::commit();
            return redirect()->back()->with(['status' => true, 'message' => 'Requisition created successfully']);
        } catch (Exception $e) {
            DB::rollBack();
           return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong'.$e->getMessage()]);
        }
    }

    //requisiton save page
    public function requisitionSavePage()
    {
        $products = Product::with('category')->get();
        return Inertia::render('Requisition/RequisitionSavePage',['products'=>$products]);
    }

    //requisition received request
    public function requisitionReceivedRequest(Request $request)
    {

       try{
         $productId=RequisitionProduct::where('id', $request->requisition_product_id)->first()->product_id;
         RequisitionReceivedRequest::create([
            'requisitionProduct_id' => $request->requisition_product_id,
            'received_qty' => $request->received_qty,
            'product_id' => $productId,
        ]);
        return redirect()->back()->with(['status' => true, 'message' => 'Request sent successfully']);
       }catch(Exception $e){
           return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
       }
    }

    //requisition approved request
    public function requisitionApproveRequest(Request $request)
    {

        try{
                  $receivedRequest = RequisitionReceivedRequest::findOrFail($request->query('received_id'));

        // Update status
        $receivedRequest->update([
            'status' => $request->query('status'),
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

        return redirect()->back()->with(['status' => true, 'message' => "Request {$request->query('status')} successfully"]);
        }catch(Exception $e){
            return redirect()->back()->with(['status' => false, 'message' => 'somethintg went wrong']);
        }
    }



    //requisition received request list
    public function requisitionReceivedRequestList()
    {
        $recievedRequests = RequisitionReceivedRequest::with('product', 'requisitionProduct')->get();
        return Inertia::render('Requisition/RequisitionReceivedRequestPage', ['recievedRequests' => $recievedRequests]);
    }

    //requisition product list
    public function requisitionProductList()
    {
        $requisitionProducts = RequisitionProduct::with('product', 'requisition')->get();
        return Inertia::render('Requisition/RequisitionProductPage', ['requisitionProducts' => $requisitionProducts]);

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
