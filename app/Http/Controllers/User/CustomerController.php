<?php

namespace App\Http\Controllers\User;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CustomerCollection(User::customers()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "name" => $request->firstname . " " . $request->lastname,
                "email" => $request->email,
                "password" => $request->password,
                "role_id" => 2
            ]);
            DB::commit();

            $response = [
                'user_info' => $user
            ];
            return Helpers::returnJsonResponse(config('constants.RECORD_CREATED'), Response::HTTP_ACCEPTED, $response);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = User::customers()->find($id);
        if (!$customer) {
            return Helpers::returnJsonResponse(config('constants.RECORD_NOTFOUND'), Response::HTTP_NOT_FOUND);
        }
        return Helpers::returnJsonResponse(config('constants.RECORD_INFO'), Response::HTTP_OK, new UserResource($customer));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegisterRequest $request, string $id)
    {
        $data = $request->all();
        $customer = User::find($id);

        try {
            DB::beginTransaction();
            $customer->update($data);
            DB::commit();

            return Helpers::returnJsonResponse(config('constants.RECORD_UPDATED'), Response::HTTP_ACCEPTED, new UserResource($customer));
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
        $user = User::customers()->find($id);
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();

            return Helpers::returnJsonResponse(config('constants.RECORD_DELETED'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function suspend(string $id)
    {
        $user = User::customers()->find($id);
        $user->suspended = 1;
        try {
            DB::beginTransaction();
            $user->update();

            $user->tokens()->delete();
            DB::commit();

            return Helpers::returnJsonResponse(config('constants.ACCOUNT_SUSPENDED'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
