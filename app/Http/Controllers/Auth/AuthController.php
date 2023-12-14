<?php

namespace App\Http\Controllers\Auth;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\PasswordResetToken;
use Hash;

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
        $otp = $this->generateOTP(6); // 6 digit otp

        try {
            DB::beginTransaction();
            $user = User::create([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "name" => $request->firstname . " " . $request->lastname,
                "email" => $request->email,
                "password" => $request->password,
                'otp' => $otp
            ]);
            DB::commit();

            // commented out, will not attempt to login.
            // Auth::attempt(['email' => $user->email, 'password' => $request->password]);
            // $user = auth()->user();

            $message = "Successfully registered.";

            $response = [
                'token' => $user->createToken(config("app.key"))->plainTextToken,
                //'user_info' => $user
                'user_info' => null // set to null, verify with OTP first.
            ];

            $this->sendRegistrationEmail($user->email, 'Calcium & Joyjoy - Registration', $otp, $user);
            
            return Helpers::returnJsonResponse("Registered successfully, kindly verify your email first.", Response::HTTP_ACCEPTED, $response);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::returnJsonResponse(config('constants.RECORD_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(LoginRequest $request)
    {
        $check = Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role_id' => 1]);
        
        if (!$check) {
            return Helpers::returnJsonResponse("Credentials doesn't match our records.", Response::HTTP_OK);
        }

        $user = auth()->user();

        if ($user->otp != 'verified') {
            $user->tokens()->delete();

            return Helpers::returnJsonResponse(config('constants.ACCOUNT_NOT_VERIFIED'), Response::HTTP_FORBIDDEN);
        }

        if ($user->suspended) {
            $user->tokens()->delete();

            return Helpers::returnJsonResponse(config('constants.ACCOUNT_SUSPENDED'), Response::HTTP_FORBIDDEN);
        }

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

    public function resetMyPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(64);

            $insert = DB::table('password_reset_tokens')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);

            if ($insert) {
                Mail::send('email.forgetPassword', ['token' => $token, 'user' => $user], function($message) use($request, $user) {
                    $message->from('spicyburns90+reset@gmail.com', 'Calcium and Joyjoy');
                    $message->to($request->email, $user->name);
                    $message->subject('Reset Password');
                });
            } else {
                return Helpers::returnJsonResponse("Operation failed", Response::HTTP_OK);
            }
    
            return Helpers::returnJsonResponse("We have e-mailed your password reset link!", Response::HTTP_OK);
        } else {
            return Helpers::returnJsonResponse("Email not found", Response::HTTP_OK);
        }
    }

    public function verifyToken($token) 
    { 
        $check = PasswordResetToken::where('token', $token)->first();
        if ($check) {
            return Helpers::returnJsonResponse("Valid Token", Response::HTTP_OK);
        } else {
            return Helpers::returnJsonResponse("Invalid Token", Response::HTTP_OK);
        }
    }

    public function submitResetPassword(Request $request)
    {
        if ($request->password == $request->password_confirmation) {
            $updatePassword = DB::table('password_reset_tokens')->where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

            if (!$updatePassword) {
                return Helpers::returnJsonResponse("Invalid Token", Response::HTTP_OK);
            }

            $user = User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

            return Helpers::returnJsonResponse("Your password has been changed!", Response::HTTP_OK);
        } else {
            return Helpers::returnJsonResponse("Password does not match", Response::HTTP_OK);
        }
    }

    private function generateOTP($otpLength) 
    {
        $characters = '0123456789';

        $charactersLength = strlen($characters);
        $otp = '';
        for ($i = 0; $i < $otpLength; $i++) {
            $otp .= $characters[rand(0, $charactersLength - 1)];
        }
    
        return $otp;
    }

    private function sendRegistrationEmail($to, $subject, $otp, $user) 
    {
        try {
            $data = ['subject' => $subject, 'user' => $user, 'otp' => $otp];
    
            Mail::send('email.otp', $data, function ($message) use ($to, $subject, $data) {
                $message->to($to)
                    ->from('calciumandjoyjoy@gmail.com', 'Calcium and Joyjoy')
                    ->subject($subject);
            });
    
            return true;
        } catch (\Exception $e) {
            \Log::error("Error sending email to $to: " . $e->getMessage());
            return false;
        }
    }

    public function adminLogin(LoginRequest $request)
    {
        Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role_id' => 2]);
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
}
