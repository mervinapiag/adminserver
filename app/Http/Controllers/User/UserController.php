<?php

namespace App\Http\Controllers\User;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $data = new UserResource($request->user());

        return Helpers::returnJsonResponse("User Information", Response::HTTP_OK, $data);
    }

    public function updateInfo(Request $request)
    {
        $user = $request->user();
        $data = $request->all();

        try {
            DB::beginTransaction();
            $user->update($data);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse("Failed to update user information", Response::HTTP_BAD_REQUEST);
        }
        return Helpers::returnJsonResponse("User Information updated", Response::HTTP_OK, $user);

    }
}
