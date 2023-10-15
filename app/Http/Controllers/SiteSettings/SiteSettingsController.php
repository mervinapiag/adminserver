<?php

namespace App\Http\Controllers\SiteSettings;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteSettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Ignoring this as the site settings is only one resource
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteSettingsRequest $request)
    {
        // Check if there is an existing site settings
        $sitesSettings = SiteSetting::first();

        if ($sitesSettings) {
            return Helpers::returnJsonResponse("Site Settings already created", Response::HTTP_BAD_REQUEST);
        }

        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Store new image with a more unique name
            $imageName = time() . '_' . $request->logo->getClientOriginalName();
            $request->logo->storeAs('public', $imageName);
            $data['logo'] = $imageName;
        }

        try {
            DB::beginTransaction();
            
            $site = SiteSetting::create($data);

            DB::commit();

            return Helpers::returnJsonResponse("Site Settings successfully created", Response::HTTP_CREATED, $site);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse("Can't create Site's Settings" . $th, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the *first resource.
     */
    public function show(string $id)
    {
        $siteSettings = SiteSetting::first();
        return Helpers::returnJsonResponse("Site Settings", Response::HTTP_OK, $siteSettings);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteSettingsRequest $request, string $id)
    {
        $siteSettings = SiteSetting::first();
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            // Store new image with a more unique name
            $imageName = time() . '_' . $request->logo->getClientOriginalName();
            $request->logo->storeAs('public', $imageName);
            $data['logo'] = $imageName;
        }
        try {
            DB::beginTransaction();
            
            $siteSettings->update($data);

            DB::commit();

            return Helpers::returnJsonResponse("Site Settings successfully updated", Response::HTTP_CREATED, $siteSettings);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse("Can't update Site's Settings" . $th, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siteSettings = SiteSetting::first();
        try {
            DB::beginTransaction();
            
            $siteSettings->delete();

            DB::commit();

            return Helpers::returnJsonResponse("Site Settings successfully deleted", Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse("Can't delete Site's Settings" . $th, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
