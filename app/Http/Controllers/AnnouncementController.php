<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\AnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Helpers::returnJsonResponse('Announcements', Response::HTTP_CREATED, AnnouncementResource::collection(Announcement::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementRequest $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $data = Announcement::create($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been created', Response::HTTP_CREATED, $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to create your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return Helpers::returnJsonResponse('Help Information', Response::HTTP_OK, new AnnouncementResource($announcement));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $announcement = Announcement::find($id);

        try {
            DB::beginTransaction();
            $announcement->update($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been updated', Response::HTTP_ACCEPTED, new AnnouncementResource($announcement));
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
        $announcement = Announcement::find($id);
        try {
            DB::beginTransaction();
            $announcement->delete();
            DB::commit();

            return Helpers::returnJsonResponse('Record has been deleted', Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse('Failed to delete your record', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
