<?php

namespace App\Http\Controllers\Discount;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Http\Resources\DiscountCollection;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new DiscountCollection(Discount::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $data = Discount::create($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been created', Response::HTTP_CREATED, new DiscountResource($data));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to create your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        return Helpers::returnJsonResponse('Record Information', Response::HTTP_OK, new DiscountResource($discount));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, string $id)
    {
        $data = $request->all();
        $discount = Discount::find($id);

        try {
            DB::beginTransaction();
            $discount->update($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been updated', Response::HTTP_ACCEPTED, new DiscountResource($discount));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to update your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = Discount::find($id);
        try {
            DB::beginTransaction();
            $discount->delete();
            DB::commit();

            return Helpers::returnJsonResponse('Record has been deleted', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to delete your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Querying archived / soft deleted data
     */
    public function getArchived()
    {
        return new DiscountCollection(Discount::onlyTrashed()->paginate());
    }
}
