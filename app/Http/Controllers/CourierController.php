<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\CourierRequest;
use App\Http\Resources\CourierCollection;
use App\Http\Resources\CourierResource;
use App\Models\Courier;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CourierCollection(Courier::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourierRequest $request)
    {
        $data = $request->all();

        try {
            DB::beginTransaction();
            $data = Courier::create($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been created', Response::HTTP_CREATED, new CourierResource($data));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to create your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier)
    {
        return Helpers::returnJsonResponse('Record Information', Response::HTTP_OK, new CourierResource($courier));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourierRequest $request, string $id)
    {
        $data = $request->all();
        $courier = Courier::find($id);

        try {
            DB::beginTransaction();
            $courier->update($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been updated', Response::HTTP_ACCEPTED, new CourierResource($courier));
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
        $courier = Courier::find($id);
        try {
            DB::beginTransaction();
            $courier->delete();
            DB::commit();

            return Helpers::returnJsonResponse('Record has been deleted', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to delete your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
