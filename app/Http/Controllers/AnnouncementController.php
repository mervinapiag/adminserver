<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\AnnouncementRequest;
use App\Http\Resources\AnnouncementCollection;
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
        return new AnnouncementCollection(Announcement::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('media')) {
            // Store new image with a more unique name
            $imageName = time() . '_' . $request->media->getClientOriginalName();
            $request->media->storeAs('public', $imageName);
            $data['media'] = $imageName;
        }

        try {
            DB::beginTransaction();
            $data = Announcement::create($data);
            DB::commit();

            return Helpers::returnJsonResponse('Record has been created', Response::HTTP_CREATED, new AnnouncementResource($data));
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
        return Helpers::returnJsonResponse('Record Information', Response::HTTP_OK, new AnnouncementResource($announcement));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnnouncementRequest $request, string $id)
    {
        $data = $request->all();
        $announcement = Announcement::find($id);

        if ($request->hasFile('media')) {
            // Store new image with a more unique name
            $imageName = time() . '_' . $request->media->getClientOriginalName();
            $request->media->storeAs('public', $imageName);
            $data['media'] = $imageName;
        }

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

    /**
     * Querying archived / soft deleted data
     */
    public function getArchived()
    {
        return new AnnouncementCollection(Announcement::onlyTrashed()->paginate());
    }
}
