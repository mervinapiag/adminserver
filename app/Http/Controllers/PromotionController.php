<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\PromotionRequest;
use App\Http\Resources\PromotionCollection;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PromotionCollection(Promotion::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromotionRequest $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $data = Promotion::create($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been created', Response::HTTP_CREATED, new PromotionResource($data));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to create your record' . $th, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        return Helpers::returnJsonResponse('Record Information', Response::HTTP_OK, new PromotionResource($promotion));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $discount = Promotion::find($id);

        try {
            DB::beginTransaction();
            $discount->update($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been updated', Response::HTTP_ACCEPTED, new PromotionResource($discount));
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
        $discount = Promotion::find($id);
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
}
