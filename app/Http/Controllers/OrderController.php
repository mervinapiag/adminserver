<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Checkout;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Checkout::all();
        //return new OrderCollection(Order::paginate());
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(OrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $data = Checkout::find($id);
        return Helpers::returnJsonResponse(config('constants.RECORD_INFO'), Response::HTTP_OK, new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     * Will update the status of the order.
     * IF status becomes 'DONE' automatically archive it???
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Archive order for later viewing.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        try {
            DB::beginTransaction();
            $order->delete();
            DB::commit();

            return Helpers::returnJsonResponse(config('constants.RECORD_DELETED'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getArchived()
    {
        return new OrderCollection(Order::onlyTrashed()->paginate());
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Checkout::find($id);
        try {
            DB::beginTransaction();
            $order->status = $request->status;
            $order->save();
            DB::commit();

            return Helpers::returnJsonResponse('Order status updated', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateTracking(Request $request, $id)
    {
        $order = Checkout::find($id);
        try {
            DB::beginTransaction();
            $order->tracking_number = $request->tracking_number;
            $order->tracking_url = $request->tracking_url;
            $order->estimated_delivery_date = $request->estimated_delivery_date;
            $order->save();
            DB::commit();

            return Helpers::returnJsonResponse('Order tracking updated', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Checkout::find($id);
        try {
            DB::beginTransaction();
            $order->payment_status = $request->payment_status;
            $order->save();
            DB::commit();

            return Helpers::returnJsonResponse('Order tracking updated', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
