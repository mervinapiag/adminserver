<?php

namespace App\Http\Controllers\User;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Checkout;

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
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_BAD_REQUEST);
        }
        return Helpers::returnJsonResponse(config('constants.RECORD_UPDATED'), Response::HTTP_OK, $user);
    }

    public function orders()
    {
        $user = $request->user();
        $orders = Checkout::where('user_id', $user->id)->get();

        return Helpers::returnJsonResponse("User Orders", Response::HTTP_OK, $orders);
    }

    public function ordersDetail($id)
    {
        $user = $request->user();
        $order = Checkout::where('user_id', $user->id)->where('id', $id)->first();

        return Helpers::returnJsonResponse("Orders Details", Response::HTTP_OK, $order);
    }
}
