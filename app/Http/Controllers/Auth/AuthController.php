<?php

namespace App\Http\Controllers\Auth;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * DB is used to create a safety net for DB data manipulation.
     * 
     * In here we used the `transaction` functionality.
     * beginTransaction() will test if the function below it runs WITHOUT fail.
     * IF by any chance, the User::create() function returns an error in the middle
     * of inserting data on the database, it will go to the catch() part and it 
     * will DB::rollback(), meaning it will delete the inserted row in the DB.
     * 
     * DB::commit() will close the transaction, meaning it inserted the data
     * to the database without a problem.
     * 
     */
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "name" => $request->firstname . " " . $request->lastname,
                "email" => $request->email,
                "password" => $request->password
            ]);
            DB::commit();

            Auth::attempt(['email' => $user->email, 'password' => $request->password]);
            $user = auth()->user();

            $message = "Successfully registered.";

            $response = [
                'token' => $user->createToken(config("app.key"))->plainTextToken,
                'user_info' => $user
            ];
            return Helpers::returnJsonResponse("Registered successfully", Response::HTTP_ACCEPTED, $response);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse("Failed to register user. Please try again", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        $user = auth()->user();

        if ($user) {
            $response = [
                'token' => $user->createToken(config("app.key"))->plainTextToken,
                'user_info' => new UserResource($user)
            ];
        } else {
            return Helpers::returnJsonResponse("Credentials doesn't match our records.", Response::HTTP_OK);
        }
        return Helpers::returnJsonResponse("Login successfully", Response::HTTP_OK, $response);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return Helpers::returnJsonResponse("Logout successfully", Response::HTTP_OK);
    }
}
