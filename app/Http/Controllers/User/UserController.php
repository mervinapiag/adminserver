<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function me(Request $request)
    {
        return response()
            ->json([
                'message' => "User Information",
                'data' => new UserResource($request->user())
            ], 200);
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
            return response()->json([
                'message' => "Failed to update user information" .$th,
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()
            ->json([
                'message' => 'User Information successully updated.',
                'data' => $user
            ], 200);
    }
}
