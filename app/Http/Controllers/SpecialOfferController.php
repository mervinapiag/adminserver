<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\SpecialOfferRequest;
use App\Http\Resources\SpecialOfferCollection;
use App\Http\Resources\SpecialOfferResoure;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SpecialOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SpecialOfferCollection(SpecialOffer::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialOfferRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Store new image with a more unique name
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imageName);
            $data['image'] = $imageName;
        }

        try {
            DB::beginTransaction();
            $data = SpecialOffer::create($data);
            DB::commit();

            return Helpers::returnJsonResponse(config('constants.RECORD_CREATED'), Response::HTTP_CREATED, new SpecialOfferResoure($data));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SpecialOffer $special_offer)
    {
        return Helpers::returnJsonResponse(config('constants.RECORD_INFO'), Response::HTTP_OK, new SpecialOfferResoure($special_offer));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecialOfferRequest $request, string $id)
    {
        $data = $request->all();
        $discount = SpecialOffer::find($id);

        if ($request->hasFile('image')) {
            // Store new image with a more unique name
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imageName);
            $data['image'] = $imageName;
        }

        try {
            DB::beginTransaction();
            $discount->update($data);
            DB::commit();

            return Helpers::returnJsonResponse(config('constants.RECORD_UPDATED'), Response::HTTP_ACCEPTED, new SpecialOfferResoure($discount));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offer = SpecialOffer::find($id);
        try {
            DB::beginTransaction();
            $offer->delete();
            DB::commit();

            return Helpers::returnJsonResponse(config('constants.RECORD_DELETED'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
