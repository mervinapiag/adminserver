<?php

namespace App\Http\Controllers\SiteSettings;

use App\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HelpCenterRequest;
use App\Http\Resources\HelpCenterResource;
use App\Models\HelpCenter;
use App\Models\SiteSetting;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class HelpCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Helpers::returnJsonResponse('Help Center Information', Response::HTTP_CREATED, HelpCenterResource::collection(HelpCenter::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HelpCenterRequest $request)
    {
        $data = $request->all();
        $siteSettings = SiteSetting::first();
        $data['site_setting_id'] = $siteSettings->id;

        try {
            DB::beginTransaction();
            $data = HelpCenter::create($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been created', Response::HTTP_CREATED, new HelpCenterResource($data));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to create your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HelpCenter $help_center)
    {
        return Helpers::returnJsonResponse('Help Information', Response::HTTP_OK, new HelpCenterResource($help_center));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HelpCenterRequest $request, string $id)
    {
        $data = $request->all();
        $help_center = HelpCenter::find($id);

        try {
            DB::beginTransaction();
            $help_center->update($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been updated', Response::HTTP_ACCEPTED, new HelpCenterResource($help_center));
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
        $help_center = HelpCenter::find($id);
        try {
            DB::beginTransaction();
            $help_center->delete();
            DB::commit();

            return Helpers::returnJsonResponse('Record has been deleted', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to delete your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
