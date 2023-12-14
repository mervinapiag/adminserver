<?php

namespace App\Http\Controllers\User;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Checkout;
use App\Models\UserShippingAddress;
use App\Models\Wishlist;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $data = new UserResource($request->user());

        return Helpers::returnJsonResponse("User Information", Response::HTTP_OK, $data);
    }

    public function updateInfo(Request $request)
    {
        $user = new UserResource($request->user());
        $data = $request->all();
        $data['phonenumber'] = $data['phone_number'];
        try {
            DB::beginTransaction();
            $user->update($data);

            // $user->phonenumber = $data['phone_number'];
            // $user->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse($th->getMessage(), Response::HTTP_BAD_REQUEST);
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_BAD_REQUEST);
        }
        return Helpers::returnJsonResponse(config('constants.RECORD_UPDATED'), Response::HTTP_OK, $user);
    }

    public function orders(Request $request)
    {
        $user = new UserResource($request->user());
        $orders = Checkout::where('user_id', $user->id)->get();

        return Helpers::returnJsonResponse("User Orders", Response::HTTP_OK, $orders);
    }

    public function ordersDetail($id)
    {
        $user = new UserResource($request->user());
        $order = Checkout::where('user_id', $user->id)->where('id', $id)->first();

        return Helpers::returnJsonResponse("Orders Details", Response::HTTP_OK, $order);
    }

    public function address(Request $request)
    {
        $user = new UserResource($request->user());
        $data = UserShippingAddress::where('user_id', $user->id)->get();

        return Helpers::returnJsonResponse("User Address", Response::HTTP_OK, $data);
    }

    public function addressStore(Request $request)
    {
        $user = new UserResource($request->user());
        $data = UserShippingAddress::where('user_id', $user->id)->get();

        if (count($data) <= 3) {
            $address = UserShippingAddress::create([
                'user_id' => $user->id,
                'first_name' => $request->finalAddress['first_name'],
                'last_name' => $request->finalAddress['last_name'],
                'street_address' => $request->finalAddress['street_address'],
                'building_address' => $request->finalAddress['building_address'],
                'province' => $request->finalAddress['province'],
                'city_municipality' => $request->finalAddress['city_municipality'],
                'barangay' => $request->finalAddress['barangay'],
                'postal_code' => $request->finalAddress['postal_code'],
                'email' => $request->finalAddress['email'],
                'phone_number' => $request->finalAddress['phone_number'],
                'label' => $request->finalAddress['label'],
                'region' => $request->finalAddress['region']
            ]);

            return Helpers::returnJsonResponse("User Address", Response::HTTP_OK, $address);
        } else {
            return Helpers::returnJsonResponse('Limit for address is 3, please delete old records before adding new record', Response::HTTP_BAD_REQUEST);
        }
    }

    public function addressUpdate(Request $request)
    {
        try {
            $input = $request->all();
            $data = UserShippingAddress::find($request->id)->update($input);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update address', 'message' => $e->getMessage()], 500);
        }
    }

    public function addressDelete(Request $request)
    {
        try {
            $input = $request->all();
            $data = UserShippingAddress::find($request->id)->delete();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete address', 'message' => $e->getMessage()], 500);
        }
    }

    public function wishlist(Request $request)
    {
        $user = new UserResource($request->user());
        $data = Wishlist::where('user_id', $user->id)->get();

        return Helpers::returnJsonResponse("User's Wishlist", Response::HTTP_OK, $data);
    }
    
    public function wishlistStore(Request $request)
    {
        try {
            $user = new UserResource($request->user());
            $data = Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ]);

            return response()->json($data, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create wishlist', 'message' => $e->getMessage()], 500);
        }
    }

    public function wishlistDestroy($id)
    {
        try {
            $data = Wishlist::find($id)->delete();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete address', 'message' => $e->getMessage()], 500);
        }
    }
}
